<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Program;
use App\Models\Speaker;
use App\Models\Workshop;
use Carbon\CarbonInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * Tabbed detail of an event: about, speakers, workshops, main session,
 * location, programme, gallery and registration.
 */
class Detail extends Component
{
    public Event $event;

    #[Url(as: 'tab', except: 'about')]
    public string $tab = 'about';

    /** Programme day shown, as Y-m-d. */
    public string $programDay = '';

    /** Selected workshop group: a programme entry id (sync_workshop) or a day as Y-m-d. */
    public string $workshopGroup = '';

    public string $workshopLine = '';

    public ?int $speakerModal = null;

    public function mount(): void
    {
        if (! array_key_exists($this->tab, $this->tabs())) {
            $this->tab = 'about';
        }

        $this->programDay = (string) ($this->programDays()->keys()->first() ?? '');
        $this->workshopGroup = (string) ($this->workshopGroups()->keys()->first() ?? '');
    }

    public function selectTab(string $tab): void
    {
        if (array_key_exists($tab, $this->tabs())) {
            $this->tab = $tab;
            $this->speakerModal = null;
            $this->dispatch('tab-changed', tab: $tab);
        }
    }

    public function selectProgramDay(string $day): void
    {
        if ($this->programDays()->has($day)) {
            $this->programDay = $day;
        }
    }

    public function shiftProgramDay(int $offset): void
    {
        $this->programDay = $this->shift($this->programDays()->keys(), $this->programDay, $offset);
    }

    public function selectWorkshopGroup(string $group): void
    {
        if ($this->workshopGroups()->has($group)) {
            $this->workshopGroup = $group;
            $this->workshopLine = '';
        }
    }

    public function shiftWorkshopGroup(int $offset): void
    {
        $this->workshopGroup = $this->shift($this->workshopGroups()->keys(), $this->workshopGroup, $offset);
        $this->workshopLine = '';
    }

    public function openSpeaker(int $speakerId): void
    {
        $this->speakerModal = $this->speakers()->firstWhere('id', $speakerId)?->id;
    }

    public function closeSpeaker(): void
    {
        $this->speakerModal = null;
    }

    /** Programme entry that is a main session, opened from the programme tab. */
    public function showMainSession(int $programId): void
    {
        $this->selectTab('main_session');
        $this->dispatch('scroll-to', id: "main_session_{$programId}");
    }

    /** Workshop slot opened from the programme tab. */
    public function showWorkshops(int $programId): void
    {
        $this->selectTab('workshops');
        $this->selectWorkshopGroup((string) $programId);
    }

    /** @return array<string, string> tab key => label */
    #[Computed]
    public function tabs(): array
    {
        $event = $this->event;
        $tabs = [
            'about' => $event->about_tab ?: __('events.tabs.about'),
            'speakers' => $event->speaker_tab ?: __('events.tabs.speakers'),
            'workshops' => $event->workshop_tab ?: __('events.tabs.workshops'),
            'main_session' => $event->main_session_tab ?: __('events.tabs.main_session'),
            'location' => $event->location_tab ?: __('events.tabs.location'),
            'program' => $event->program_tab ?: __('events.tabs.program'),
            'gallery' => $event->gallery_tab ?: __('events.tabs.gallery'),
            'registration' => $event->registration_tab ?: __('events.tabs.registration'),
        ];

        if ($this->speakers()->isEmpty()) {
            unset($tabs['speakers']);
        }

        if ($event->workshops->isEmpty()) {
            unset($tabs['workshops']);
        }

        if ($this->mainSessions()->isEmpty()) {
            unset($tabs['main_session']);
        }

        if ($event->programs->isEmpty()) {
            unset($tabs['program']);
        }

        if (blank($event->url_gallery) && blank($event->url_video) && $event->galleries->isEmpty()) {
            unset($tabs['gallery']);
        }

        if (! $event->registration) {
            unset($tabs['registration']);
        }

        return $tabs;
    }

    /** Speakers of the event with their programme entries and workshops grouped by day. */
    #[Computed]
    public function speakers(): Collection
    {
        $eventId = $this->event->id;

        return Speaker::query()
            ->where(fn ($query) => $query
                ->whereHas('events', fn ($q) => $q->where('events.id', $eventId))
                ->orWhereHas('programs', fn ($q) => $q->where('event_id', $eventId))
                ->orWhereHas('workshops', fn ($q) => $q->where('event_id', $eventId)))
            ->with([
                'programs' => fn ($q) => $q->where('event_id', $eventId)->orderBy('date_start'),
                'workshops' => fn ($q) => $q->where('event_id', $eventId)->with('schedules.schedule'),
            ])
            ->get()
            ->sortBy(fn (Speaker $speaker) => Str::lower((string) $speaker->name))
            ->values();
    }

    /** @return Collection<string, string> Y-m-d => label */
    #[Computed]
    public function programDays(): Collection
    {
        return $this->event->programs
            ->sortBy('date_start')
            ->mapWithKeys(fn (Program $program) => [$program->date_start->format('Y-m-d') => $this->dayLabel($program->date_start)]);
    }

    #[Computed]
    public function programsOfDay(): Collection
    {
        return $this->event->programs
            ->filter(fn (Program $program) => $program->date_start->format('Y-m-d') === $this->programDay)
            ->sortBy('date_start')
            ->values();
    }

    #[Computed]
    public function mainSessions(): Collection
    {
        return $this->event->programs->where('main_session', true)->sortBy('date_start')->values();
    }

    /**
     * Workshop groups: the programme's workshop slots when they exist, else the days workshops run.
     *
     * @return Collection<string, array{label: string, workshops: Collection<int, Workshop>}>
     */
    #[Computed]
    public function workshopGroups(): Collection
    {
        $slots = $this->event->programs->where('sync_workshop', true)->sortBy('date_start');

        if ($slots->isNotEmpty()) {
            return $slots
                ->mapWithKeys(fn (Program $slot) => [(string) $slot->id => [
                    'label' => (string) $slot->title,
                    'workshops' => $this->event->workshops->filter(fn (Workshop $workshop) => $workshop->schedules
                        ->contains(fn ($pivot) => $pivot->schedule && $pivot->schedule->date_start->copy()->addMinutes(5)->between($slot->date_start, $slot->date_end))),
                ]])
                ->filter(fn (array $group) => $group['workshops']->isNotEmpty());
        }

        $groups = collect();

        foreach ($this->event->workshops as $workshop) {
            foreach ($workshop->schedules as $pivot) {
                if (! $pivot->schedule) {
                    continue;
                }

                $day = $pivot->schedule->date_start->format('Y-m-d');
                $group = $groups->get($day, ['label' => $this->dayLabel($pivot->schedule->date_start), 'workshops' => collect()]);
                $group['workshops'] = $group['workshops']->push($workshop)->unique('id');
                $groups->put($day, $group);
            }
        }

        return $groups->sortKeys();
    }

    #[Computed]
    public function workshopsOfGroup(): Collection
    {
        $workshops = $this->workshopGroups()->get($this->workshopGroup)['workshops'] ?? collect();

        return $workshops
            ->when($this->workshopLine !== '', fn (Collection $items) => $items->where('line_id', (int) $this->workshopLine))
            ->sortBy(fn (Workshop $workshop) => Str::lower((string) $workshop->title))
            ->values();
    }

    /** Tracks present in the selected workshop group. */
    #[Computed]
    public function workshopLines(): Collection
    {
        $workshops = $this->workshopGroups()->get($this->workshopGroup)['workshops'] ?? collect();

        return $workshops->pluck('line')->filter()->unique('id')->sortBy(fn ($line) => (string) $line->title)->values();
    }

    #[Computed]
    public function speakerInModal(): ?Speaker
    {
        return $this->speakerModal ? $this->speakers()->firstWhere('id', $this->speakerModal) : null;
    }

    public function youtubeEmbed(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{6,})/', $url, $match)) {
            return "https://www.youtube.com/embed/{$match[1]}";
        }

        return $url;
    }

    public function render(): View
    {
        return view('livewire.events.detail');
    }

    private function dayLabel(CarbonInterface $date): string
    {
        return Str::title($date->locale(app()->getLocale())->isoFormat('ddd. MMM D'));
    }

    /** @param  Collection<int, string>  $keys */
    private function shift(Collection $keys, string $current, int $offset): string
    {
        $keys = $keys->values();
        $index = $keys->search($current);

        if ($index === false || $keys->isEmpty()) {
            return (string) ($keys->first() ?? '');
        }

        return (string) $keys->get(max(0, min($keys->count() - 1, $index + $offset)), $current);
    }
}
