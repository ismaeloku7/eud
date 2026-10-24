<?php

namespace App\Legacy\Steps;

use App\Legacy\LegacyContext;
use App\Legacy\TableCopy;

class EventsStep implements ImportStep
{
    public static function name(): string
    {
        return 'events';
    }

    public function run(LegacyContext $context): void
    {
        TableCopy::for('speakers')->translatable(['name', 'description', 'type'])->paths(['photo'])->run($context);
        TableCopy::for('schedules')->translatable(['name'])->run($context);

        // The previous site ignored `publish` on the public pages, so every event was visible.
        TableCopy::for('events')
            ->translatable([
                'slug', 'title', 'subtitle', 'description', 'type', 'slogan', 'quote', 'tags',
                'location', 'location_description', 'registration_eud', 'registration_non_eud',
                'about_tab', 'speaker_tab', 'speaker_title', 'workshop_tab', 'workshop_title', 'workshop_description',
                'location_tab', 'location_title', 'program_tab', 'program_title', 'program_subtitle', 'program_description',
                'gallery_tab', 'gallery_title', 'main_session_tab', 'main_session_title', 'registration_tab', 'registration_title',
            ])
            ->json(['location_recursive', 'registration_recursive'])
            ->paths(['photo_portada', 'facebook_banner', 'image_about', 'program_image', 'program_download'])
            ->booleans(['registration'])
            ->transform(fn (array $row) => [...$row, 'publish' => 1])
            ->run($context);

        TableCopy::for('localizations')->translatable(['name', 'capacity'])->requires(['event_id' => 'events'])->run($context);

        TableCopy::for('programs')
            ->translatable(['title', 'description'])
            ->booleans(['main_session', 'sync_workshop'])
            ->requires(['event_id' => 'events'])
            ->run($context);

        TableCopy::for('workshops')
            ->translatable(['title', 'description'])
            ->booleans(['collection'])
            ->requires(['event_id' => 'events'])
            ->optional(['line_id' => 'lines'])
            ->run($context);

        TableCopy::for('workshops_schedules')
            ->requires(['workshop_id' => 'workshops', 'schedule_id' => 'schedules', 'localization_id' => 'localizations'])
            ->run($context);

        TableCopy::for('workshops_speakers')->requires(['workshop_id' => 'workshops', 'speaker_id' => 'speakers'])->run($context);
        TableCopy::for('programs_speakers')->requires(['program_id' => 'programs', 'speaker_id' => 'speakers'])->run($context);
        TableCopy::for('events_speakers')->requires(['event_id' => 'events', 'speaker_id' => 'speakers'])->run($context);

        TableCopy::for('galleries')
            ->paths(['image'])
            ->requires(['event_id' => 'events'])
            ->transform(fn (array $row) => [...$row, 'position' => $row['id']])
            ->run($context);

        TableCopy::for('downloads')
            ->translatable(['name'])
            ->paths(['document'])
            ->requires(['event_id' => 'events'])
            ->run($context);

        TableCopy::for('media')
            ->transform(function (array $row) use ($context): ?array {
                if ($row['model_type'] !== 'App\\Models\\Event' || ! $context->exists('events', $row['model_id'])) {
                    return null;
                }

                $context->files->media((int) $row['id'], (string) $row['file_name']);

                return $row;
            })
            ->run($context);
    }
}
