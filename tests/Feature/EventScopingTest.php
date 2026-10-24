<?php

namespace Tests\Feature;

use App\Legacy\EventScoping;
use App\Models\Event;
use App\Models\Line;
use App\Models\Localization;
use App\Models\Schedule;
use App\Models\Workshop;
use App\Models\WorkshopSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventScopingTest extends TestCase
{
    use RefreshDatabase;

    public function test_shared_slots_and_tracks_are_given_to_each_event_that_uses_them(): void
    {
        [$first, $second] = [$this->event('first'), $this->event('second')];
        $slot = Schedule::create(['name' => ['en' => 'Morning'], 'date_start' => '2026-07-02 10:00', 'date_end' => '2026-07-02 11:00']);
        $track = Line::create(['title' => ['en' => 'Leadership']]);
        $unused = Line::create(['title' => ['en' => 'Unused']]);

        foreach ([$first, $second] as $event) {
            $workshop = Workshop::create(['event_id' => $event->id, 'line_id' => $track->id, 'title' => ['en' => 'W']]);
            $room = Localization::create(['event_id' => $event->id, 'name' => ['en' => 'Room']]);
            WorkshopSchedule::create(['workshop_id' => $workshop->id, 'schedule_id' => $slot->id, 'localization_id' => $room->id]);
        }

        EventScoping::assign();

        $this->assertSame(1, $first->schedules()->count());
        $this->assertSame(1, $second->schedules()->count());
        $this->assertSame(1, $first->lines()->count());
        $this->assertSame(1, $second->lines()->count());

        $secondWorkshop = $second->workshops()->first();
        $this->assertSame($second->id, $secondWorkshop->line->event_id, 'the copy is used by the second event');
        $this->assertSame($second->id, $secondWorkshop->schedules()->first()->schedule->event_id);
        $this->assertNull($unused->fresh()->event_id, 'with several events an unused track cannot be placed');
    }

    private function event(string $slug): Event
    {
        return Event::create(['title' => ['en' => $slug], 'slug' => ['en' => $slug], 'date_start' => '2026-07-01', 'date_end' => '2026-07-05']);
    }
}
