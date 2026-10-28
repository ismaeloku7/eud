<?php

namespace Tests\Feature\Site;

use App\Livewire\Events\Detail;
use App\Livewire\Events\Index;
use App\Models\Event;
use App\Models\Line;
use App\Models\Localization;
use App\Models\Program;
use App\Models\Schedule;
use App\Models\Speaker;
use App\Models\Workshop;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([MinistrySeeder::class, PageSeeder::class]);
    }

    public function test_listing_shows_only_published_events(): void
    {
        $this->makeEvent('Youth Congress');
        $this->makeEvent('Secret draft', publish: false);

        $this->get('/events')
            ->assertOk()
            ->assertSee('Youth Congress')
            ->assertDontSee('Secret draft')
            ->assertSee('/events/youth-congress');
    }

    public function test_listing_can_be_searched_and_sorted(): void
    {
        $this->makeEvent('Alpha Camp', start: '2026-01-10 09:00');
        $this->makeEvent('Beta Congress', start: '2026-06-10 09:00');

        Livewire::test(Index::class)
            ->set('search', 'beta')
            ->assertSee('Beta Congress')
            ->assertDontSee('Alpha Camp')
            ->set('search', '')
            ->set('sort', 'desc')
            ->assertSeeInOrder(['Beta Congress', 'Alpha Camp'])
            ->call('resetFilters')
            ->assertSeeInOrder(['Alpha Camp', 'Beta Congress']);
    }

    public function test_detail_shows_programme_workshops_and_speakers(): void
    {
        $event = $this->makeFullEvent();

        $this->get('/events/youth-congress')
            ->assertOk()
            ->assertSee('Youth Congress')
            ->assertSee('Ana García')
            ->assertSee('Bern, Switzerland')
            ->assertSee('About');

        Livewire::test(Detail::class, ['event' => $event])
            ->call('selectTab', 'program')
            ->assertSee('Opening plenary')
            ->assertSee('10:00 - 11:30')
            ->call('selectTab', 'workshops')
            ->assertSee('Leading teams')
            ->assertSee('Room A')
            ->call('selectTab', 'speakers')
            ->assertSee('Keynote speaker');
    }

    public function test_location_tab_shows_the_photos_with_their_captions(): void
    {
        $event = $this->makeEvent('Youth Congress');
        $event->update(['location_images' => [
            ['image' => 'events/location/rooms.jpg', 'caption' => ['en' => 'Double rooms']],
            ['image' => 'events/location/map.png', 'caption' => null],
        ]]);

        Livewire::test(Detail::class, ['event' => $event->fresh(), 'tab' => 'location'])
            ->assertSeeHtml('data-lightbox')
            ->assertSee('events/location/rooms.jpg')
            ->assertSee('events/location/map.png')
            ->assertSee('Double rooms');
    }

    public function test_programme_lists_every_day_and_names_the_selected_one(): void
    {
        $event = $this->makeEvent('Trekking Camp');
        foreach (['2026-07-01 09:00', '2026-07-02 09:00', '2026-07-03 09:00', '2026-07-04 09:00', '2026-07-05 09:00', '2026-07-06 09:00'] as $start) {
            Program::create(['event_id' => $event->id, 'title' => ['en' => "Hike {$start}"], 'date_start' => $start, 'date_end' => str_replace('09:00', '12:00', $start)]);
        }

        Livewire::test(Detail::class, ['event' => $event->fresh(), 'tab' => 'program'])
            ->assertSeeInOrder(['Wed 1 Jul', 'Thu 2 Jul', 'Fri 3 Jul', 'Sat 4 Jul', 'Sun 5 Jul', 'Mon 6 Jul'])
            ->assertSee('Wednesday, July 1, 2026')
            ->call('selectProgramDay', '2026-07-06')
            ->assertSee('Monday, July 6, 2026')
            ->assertSee('Hike 2026-07-06 09:00')
            ->assertDontSee('Hike 2026-07-01 09:00');
    }

    public function test_programme_tab_shows_the_programme_image_and_pdf_without_sessions(): void
    {
        $event = $this->makeEvent('Trekking Camp');
        $event->update(['program_image' => 'events/programme.jpg', 'program_download' => 'events/files/programme.pdf']);

        $component = Livewire::test(Detail::class, ['event' => $event->fresh(), 'tab' => 'program']);

        $this->assertSame('program', $component->get('tab'));
        $component
            ->assertSee('events/programme.jpg')
            ->assertSee('events/files/programme.pdf')
            ->assertSee(__('events.programme_pdf'))
            ->assertDontSee(__('events.schedule'));
    }

    public function test_unpublished_event_is_not_found(): void
    {
        $this->makeEvent('Secret draft', publish: false);

        $this->get('/events/secret-draft')->assertNotFound();
    }

    public function test_tabs_without_content_are_hidden_and_unknown_tab_falls_back_to_about(): void
    {
        $event = $this->makeEvent('Plain event');

        $component = Livewire::test(Detail::class, ['event' => $event, 'tab' => 'nope']);

        $this->assertSame('about', $component->get('tab'));
        $this->assertSame(['about', 'location'], array_keys($component->instance()->tabs()));

        $component->call('selectTab', 'gallery');
        $this->assertSame('about', $component->get('tab'));
    }

    public function test_workshops_are_grouped_by_programme_slot_and_filtered_by_track(): void
    {
        $event = $this->makeFullEvent();
        $otherLine = Line::create(['title' => ['en' => 'Worship'], 'color' => '#00ff00']);
        $slot = Schedule::create(['name' => ['en' => 'Second'], 'date_start' => '2026-07-02 11:35', 'date_end' => '2026-07-02 12:25']);
        $room = Localization::first();
        $second = Workshop::create(['event_id' => $event->id, 'line_id' => $otherLine->id, 'title' => ['en' => 'Singing together']]);
        $second->schedules()->create(['schedule_id' => $slot->id, 'localization_id' => $room->id]);

        $component = Livewire::test(Detail::class, ['event' => $event->fresh(), 'tab' => 'workshops']);
        $programSlot = Program::where('sync_workshop', true)->first();

        $this->assertSame((string) $programSlot->id, $component->get('workshopGroup'));
        $component->assertSee('Leading teams')->assertSee('Singing together')
            ->set('workshopLine', (string) $otherLine->id)
            ->assertSee('Singing together')
            ->assertDontSee('Leading teams');
    }

    public function test_speaker_modal_lists_the_speakers_programme(): void
    {
        $event = $this->makeFullEvent();
        $speaker = Speaker::where('name->en', 'Ana García')->first();

        Livewire::test(Detail::class, ['event' => $event, 'tab' => 'speakers'])
            ->assertDontSee('Opening plenary')
            ->call('openSpeaker', $speaker->id)
            ->assertSee('Bio of Ana')
            ->assertSee('Opening plenary')
            ->call('closeSpeaker')
            ->assertDontSee('Opening plenary');
    }

    private function makeEvent(string $title, bool $publish = true, string $start = '2026-07-01 09:00'): Event
    {
        $slug = str($title)->slug()->toString();

        return Event::create([
            'title' => ['en' => $title],
            'slug' => ['en' => $slug],
            'date_start' => $start,
            'date_end' => '2026-07-05 18:00',
            'publish' => $publish,
            'location' => ['en' => 'Bern, Switzerland'],
            'description' => ['en' => '<p>About the event.</p>'],
        ]);
    }

    private function makeFullEvent(): Event
    {
        $event = $this->makeEvent('Youth Congress');
        $event->update(['registration' => true]);

        $speaker = Speaker::create(['name' => ['en' => 'Ana García'], 'type' => ['en' => 'Keynote speaker'], 'description' => ['en' => '<p>Bio of Ana.</p>']]);
        $event->speakers()->attach($speaker);

        $plenary = Program::create(['event_id' => $event->id, 'title' => ['en' => 'Opening plenary'], 'date_start' => '2026-07-02 10:00', 'date_end' => '2026-07-02 11:30', 'main_session' => true]);
        $plenary->speakers()->attach($speaker);
        Program::create(['event_id' => $event->id, 'title' => ['en' => 'Workshop block'], 'date_start' => '2026-07-02 11:30', 'date_end' => '2026-07-02 12:30', 'sync_workshop' => true]);

        $line = Line::create(['title' => ['en' => 'Leadership'], 'color' => '#2563eb']);
        $slot = Schedule::create(['name' => ['en' => 'Session 1'], 'date_start' => '2026-07-02 11:30', 'date_end' => '2026-07-02 12:30']);
        $room = Localization::create(['event_id' => $event->id, 'name' => ['en' => 'Room A'], 'capacity' => ['en' => '120']]);
        $workshop = Workshop::create(['event_id' => $event->id, 'line_id' => $line->id, 'title' => ['en' => 'Leading teams'], 'description' => ['en' => '<p>Lead.</p>']]);
        $workshop->schedules()->create(['schedule_id' => $slot->id, 'localization_id' => $room->id]);
        $workshop->speakers()->attach($speaker);

        return $event->fresh();
    }
}
