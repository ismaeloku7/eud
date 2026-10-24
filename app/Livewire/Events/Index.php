<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/** Public list of published events with search, ordering and grid/list layout. */
class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $sort = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'sort']);
        $this->resetPage();
    }

    public function render(): View
    {
        $locale = app()->getLocale();

        $events = Event::query()
            ->published()
            ->when($this->search !== '', fn ($query) => $query->where(fn ($q) => $q
                ->where("title->{$locale}", 'like', "%{$this->search}%")
                ->orWhere('title->en', 'like', "%{$this->search}%")
                ->orWhere("location->{$locale}", 'like', "%{$this->search}%")))
            ->orderBy('date_start', $this->sort === 'desc' ? 'desc' : 'asc')
            ->with('speakers')
            ->paginate(12);

        return view('livewire.events.index', ['events' => $events]);
    }
}
