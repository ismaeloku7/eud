<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;

/**
 * Time slots and workshop tracks belong to one event. Older data had them as
 * shared lists, so each row is given the event whose workshops use it; a row
 * used by several events is copied once per extra event.
 */
final class EventScoping
{
    public static function assign(): void
    {
        self::scope('schedules', 'workshops_schedules', 'schedule_id');
        self::scope('lines', 'workshops', 'line_id');
    }

    private static function scope(string $table, string $usageTable, string $foreignKey): void
    {
        $onlyEventId = DB::table('events')->count() === 1 ? DB::table('events')->value('id') : null;

        foreach (DB::table($table)->whereNull('event_id')->orderBy('id')->get() as $row) {
            $eventIds = self::eventsUsing($usageTable, $foreignKey, $row->id);

            if ($eventIds === []) {
                DB::table($table)->where('id', $row->id)->update(['event_id' => $onlyEventId]);

                continue;
            }

            DB::table($table)->where('id', $row->id)->update(['event_id' => array_shift($eventIds)]);

            foreach ($eventIds as $eventId) {
                $copy = (array) $row;
                unset($copy['id']);
                $copy['event_id'] = $eventId;
                $copyId = DB::table($table)->insertGetId($copy);

                self::repoint($usageTable, $foreignKey, $row->id, $copyId, $eventId);
            }
        }
    }

    /** @return array<int, int> */
    private static function eventsUsing(string $usageTable, string $foreignKey, int $id): array
    {
        $query = $usageTable === 'workshops'
            ? DB::table('workshops')->where($foreignKey, $id)
            : DB::table($usageTable)->join('workshops', 'workshops.id', '=', "{$usageTable}.workshop_id")->where("{$usageTable}.{$foreignKey}", $id);

        return $query->distinct()->orderBy('workshops.event_id')->pluck('workshops.event_id')->map(fn ($eventId) => (int) $eventId)->all();
    }

    private static function repoint(string $usageTable, string $foreignKey, int $from, int $to, int $eventId): void
    {
        if ($usageTable === 'workshops') {
            DB::table('workshops')->where($foreignKey, $from)->where('event_id', $eventId)->update([$foreignKey => $to]);

            return;
        }

        $workshopIds = DB::table('workshops')->where('event_id', $eventId)->pluck('id');
        DB::table($usageTable)->where($foreignKey, $from)->whereIn('workshop_id', $workshopIds)->update([$foreignKey => $to]);
    }
}
