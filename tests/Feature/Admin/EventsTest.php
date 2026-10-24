<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\RelationManagers\WorkshopsRelationManager;
use App\Models\Event;
use App\Models\Line;
use App\Models\Localization;
use App\Models\Schedule;
use App\Models\Speaker;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_event_screens_render(): void
    {
        $event = $this->makeEvent();

        foreach (['events', 'events/create', "events/{$event->id}/edit", 'speakers', 'lines', 'schedules'] as $path) {
            $this->get("/admin/{$path}")->assertOk();
        }

        $this->get('/admin/events')->assertSee('Youth Congress');
    }

    public function test_event_is_created_with_speakers_and_information_blocks(): void
    {
        $speaker = Speaker::create(['name' => ['en' => 'Ana']]);

        Livewire::test(CreateEvent::class)
            ->fillForm([
                'title' => 'Youth Congress',
                'slug' => 'youth-congress',
                'date_start' => '2026-07-01 09:00',
                'date_end' => '2026-07-05 18:00',
                'publish' => true,
                'speakers' => [$speaker->id],
                'location_recursive' => [['title' => ['en' => 'Hotel'], 'content' => ['en' => '<p>Main street</p>'], 'column' => 2]],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $event = Event::whereSlug('youth-congress')->firstOrFail();

        $this->assertTrue($event->publish);
        $this->assertTrue($event->speakers->contains($speaker));
        $this->assertSame('Hotel', $event->location_recursive[0]['title']['en']);
    }

    public function test_end_date_must_follow_start_date(): void
    {
        Livewire::test(CreateEvent::class)
            ->fillForm([
                'title' => 'Camp',
                'slug' => 'camp',
                'date_start' => '2026-07-05 09:00',
                'date_end' => '2026-07-01 18:00',
            ])
            ->call('create')
            ->assertHasFormErrors(['date_end']);
    }

    public function test_spanish_translation_is_saved_without_touching_english(): void
    {
        $event = $this->makeEvent();

        Livewire::test(EditEvent::class, ['record' => $event->getRouteKey()])
            ->set('activeLocale', 'es')
            ->fillForm(['title' => 'Congreso Juvenil', 'slug' => 'congreso-juvenil'])
            ->call('save')
            ->assertHasNoFormErrors();

        $event->refresh();
        $this->assertSame('Youth Congress', $event->getTranslation('title', 'en'));
        $this->assertSame('Congreso Juvenil', $event->getTranslation('title', 'es'));
        $this->assertTrue(Event::whereSlug('congreso-juvenil', 'es')->exists());
    }

    public function test_workshop_is_created_from_the_event_with_a_slot_and_room(): void
    {
        $event = $this->makeEvent();
        $line = Line::create(['title' => ['en' => 'Leadership'], 'color' => '#ff0000']);
        $slot = Schedule::create(['name' => ['en' => 'Morning'], 'date_start' => '2026-07-02 10:00', 'date_end' => '2026-07-02 11:00']);
        $room = Localization::create(['event_id' => $event->id, 'name' => ['en' => 'Room A']]);

        Livewire::test(WorkshopsRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class])
            ->callAction(TestAction::make('create')->table(), data: [
                'title' => 'Leading teams',
                'line_id' => $line->id,
                'schedules' => [['schedule_id' => $slot->id, 'localization_id' => $room->id]],
            ])
            ->assertHasNoActionErrors();

        $workshop = $event->workshops()->firstOrFail();
        $this->assertSame('Leading teams', $workshop->title);
        $this->assertTrue($workshop->schedules()->where('localization_id', $room->id)->where('schedule_id', $slot->id)->exists());
    }

    private function makeEvent(): Event
    {
        return Event::create([
            'title' => ['en' => 'Youth Congress'],
            'slug' => ['en' => 'youth-congress'],
            'date_start' => '2026-07-01 09:00',
            'date_end' => '2026-07-05 18:00',
        ]);
    }
}
