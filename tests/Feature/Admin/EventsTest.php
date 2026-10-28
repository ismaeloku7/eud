<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\RelationManagers\LinesRelationManager;
use App\Filament\Resources\Events\RelationManagers\SchedulesRelationManager;
use App\Filament\Resources\Events\RelationManagers\SpeakersRelationManager;
use App\Filament\Resources\Events\RelationManagers\WorkshopsRelationManager;
use App\Models\Event;
use App\Models\Line;
use App\Models\Localization;
use App\Models\Schedule;
use App\Models\Speaker;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        foreach (['events', 'events/create', "events/{$event->id}/edit"] as $path) {
            $this->get("/admin/{$path}")->assertOk();
        }

        $this->get('/admin/events')->assertSee('Youth Congress');
    }

    public function test_event_is_created_with_information_blocks(): void
    {
        Livewire::test(CreateEvent::class)
            ->fillForm([
                'title' => 'Youth Congress',
                'slug' => 'youth-congress',
                'date_start' => '2026-07-01 09:00',
                'date_end' => '2026-07-05 18:00',
                'publish' => true,
                'location_recursive' => [['title' => ['en' => 'Hotel'], 'content' => ['en' => '<p>Main street</p>'], 'column' => 2]],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $event = Event::whereSlug('youth-congress')->firstOrFail();

        $this->assertTrue($event->publish);
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

    public function test_a_poster_of_twelve_megabytes_can_be_uploaded(): void
    {
        Storage::fake('public');
        $event = $this->makeEvent();

        Livewire::test(EditEvent::class, ['record' => $event->getRouteKey()])
            ->fillForm(['image_about' => UploadedFile::fake()->image('poster.jpg')->size(12 * 1024)])
            ->call('save')
            ->assertHasNoFormErrors();

        Storage::disk('public')->assertExists($event->refresh()->image_about);
    }

    public function test_location_photos_are_saved_with_their_captions(): void
    {
        Storage::fake('public');
        $event = $this->makeEvent();

        Livewire::test(EditEvent::class, ['record' => $event->getRouteKey()])
            ->fillForm(['location_images' => [
                ['image' => [UploadedFile::fake()->image('rooms.jpg')], 'caption' => ['en' => 'Double rooms', 'es' => 'Habitaciones dobles']],
            ]])
            ->call('save')
            ->assertHasNoFormErrors();

        $photos = $event->refresh()->location_images;

        $this->assertCount(1, $photos);
        $this->assertSame(['en' => 'Double rooms', 'es' => 'Habitaciones dobles'], $photos[0]['caption']);
        Storage::disk('public')->assertExists($photos[0]['image']);
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
        $line = Line::create(['event_id' => $event->id, 'title' => ['en' => 'Leadership'], 'color' => '#ff0000']);
        $slot = Schedule::create(['event_id' => $event->id, 'name' => ['en' => 'Morning'], 'date_start' => '2026-07-02 10:00', 'date_end' => '2026-07-02 11:00']);
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

    public function test_a_speaker_from_a_previous_event_can_be_added_without_duplicating_it(): void
    {
        $previous = $this->makeEvent();
        $speaker = Speaker::create(['name' => ['en' => 'Ana García'], 'type' => ['en' => 'Keynote']]);
        $previous->speakers()->attach($speaker);
        $event = Event::create(['title' => ['en' => 'Congress 2027'], 'slug' => ['en' => 'congress-2027'], 'date_start' => '2027-07-01', 'date_end' => '2027-07-05']);

        Livewire::test(SpeakersRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class])
            ->callAction(TestAction::make('attach')->table(), data: ['recordId' => [$speaker->id]])
            ->assertHasNoActionErrors();

        $this->assertTrue($event->speakers()->whereKey($speaker->id)->exists());
        $this->assertSame(1, Speaker::count());
        $this->assertTrue($previous->speakers()->whereKey($speaker->id)->exists(), 'the previous event keeps it');
    }

    public function test_time_slots_and_tracks_are_created_inside_the_event(): void
    {
        $event = $this->makeEvent();

        Livewire::test(SchedulesRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class])
            ->callAction(TestAction::make('create')->table(), data: ['name' => 'Morning', 'date_start' => '2026-07-02 10:00', 'date_end' => '2026-07-02 11:00'])
            ->assertHasNoActionErrors();

        Livewire::test(LinesRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class])
            ->callAction(TestAction::make('create')->table(), data: ['title' => 'Leadership', 'color' => '#ff0000'])
            ->assertHasNoActionErrors();

        $this->assertSame(1, $event->schedules()->count());
        $this->assertSame(1, $event->lines()->count());
    }

    public function test_workshops_only_offer_the_tracks_and_slots_of_their_event(): void
    {
        $event = $this->makeEvent();
        $other = Event::create(['title' => ['en' => 'Other'], 'slug' => ['en' => 'other'], 'date_start' => '2025-01-01', 'date_end' => '2025-01-02']);
        Line::create(['event_id' => $event->id, 'title' => ['en' => 'Own track']]);
        $foreign = Line::create(['event_id' => $other->id, 'title' => ['en' => 'Foreign track']]);

        Livewire::test(WorkshopsRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class])
            ->callAction(TestAction::make('create')->table(), data: ['title' => 'Workshop', 'line_id' => $foreign->id])
            ->assertHasActionErrors(['line_id']);
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
