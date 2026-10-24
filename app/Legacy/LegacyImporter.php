<?php

namespace App\Legacy;

use App\Legacy\Steps\CataloguesStep;
use App\Legacy\Steps\CountriesStep;
use App\Legacy\Steps\DirectoryStep;
use App\Legacy\Steps\EventsStep;
use App\Legacy\Steps\HonorsStep;
use App\Legacy\Steps\ImportStep;
use App\Legacy\Steps\MinistriesStep;
use App\Legacy\Steps\PagesStep;
use App\Legacy\Steps\ResourcesStep;
use App\Legacy\Steps\UsersStep;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;

/** Runs the import steps in dependency order. */
final class LegacyImporter
{
    /** @var array<int, class-string<ImportStep>> */
    public const STEPS = [
        UsersStep::class,
        CataloguesStep::class,
        MinistriesStep::class,
        CountriesStep::class,
        DirectoryStep::class,
        ResourcesStep::class,
        HonorsStep::class,
        EventsStep::class,
        PagesStep::class,
    ];

    /** Content tables emptied by --fresh, children first. */
    private const CONTENT_TABLES = [
        'media', 'downloads', 'galleries', 'events_speakers', 'programs_speakers', 'workshops_speakers', 'workshops_schedules',
        'workshops', 'programs', 'localizations', 'events', 'schedules', 'speakers',
        'pdf_honors', 'honors', 'files', 'related_resources', 'project_resources', 'category_resource_resources', 'ministry_resources', 'resources',
        'office_generals', 'directors', 'countries', 'ministries',
        'lines', 'category_resources', 'master_award_honors', 'level_honors', 'class_honors', 'category_honors', 'type_directors', 'type_files', 'languages',
    ];

    /** @return array<int, string> */
    public static function stepNames(): array
    {
        return array_map(fn (string $step) => $step::name(), self::STEPS);
    }

    /**
     * @param  array<int, string>  $only  step names, empty for all
     */
    public function run(array $only, ?string $legacyRoot, bool $fresh, Closure $info, Closure $warn): FileCopier
    {
        $unknown = array_diff($only, self::stepNames());

        if ($unknown !== []) {
            throw new InvalidArgumentException('Unknown import steps: '.implode(', ', $unknown));
        }

        $context = new LegacyContext(DB::connection('legacy'), new FileCopier($legacyRoot), $info, $warn);

        if ($fresh) {
            $this->truncateContent();
            $info('Content tables emptied.');
        }

        Schema::disableForeignKeyConstraints();

        try {
            foreach (self::STEPS as $step) {
                if ($only === [] || in_array($step::name(), $only, true)) {
                    $info("== {$step::name()}");
                    (new $step)->run($context);
                }
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        cache()->flush();

        return $context->files;
    }

    private function truncateContent(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (self::CONTENT_TABLES as $table) {
            DB::table($table)->delete();
        }

        Schema::enableForeignKeyConstraints();
    }
}
