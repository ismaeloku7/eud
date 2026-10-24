<?php

namespace App\Console\Commands;

use App\Legacy\ImportLog;
use App\Legacy\LegacyImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class LegacyImportCommand extends Command
{
    protected $signature = 'legacy:import
        {--only= : Comma separated step names to run (see --steps)}
        {--files= : Root folder of the previous site, to copy uploaded files (default LEGACY_FILES_PATH)}
        {--fresh : Empty the content tables before importing}
        {--steps : List the available steps and exit}';

    protected $description = 'Import content from the previous site (Laravel 9 + Nova) through the "legacy" database connection';

    public function handle(LegacyImporter $importer): int
    {
        if ($this->option('steps')) {
            $this->line(implode(PHP_EOL, LegacyImporter::stepNames()));

            return self::SUCCESS;
        }

        try {
            DB::connection('legacy')->getPdo();
        } catch (Throwable $exception) {
            $this->error('Cannot connect to the legacy database: '.$exception->getMessage());
            $this->line('Set DB_LEGACY_* in .env (see .env.example).');

            return self::FAILURE;
        }

        $only = array_values(array_filter(array_map('trim', explode(',', (string) $this->option('only')))));
        $legacyRoot = $this->option('files') ?: (config('site.legacy.files_path') ?: null);

        if ($legacyRoot && ! is_dir($legacyRoot)) {
            $this->error("Legacy files folder not found: {$legacyRoot}");

            return self::FAILURE;
        }

        if (! $legacyRoot) {
            $this->warn('No legacy files folder given: uploaded files will be listed for `legacy:fetch-files`.');
        }

        $warnings = 0;

        $files = $importer->run(
            $only,
            $legacyRoot,
            (bool) $this->option('fresh'),
            fn (string $message) => $this->line($message),
            function (string $message) use (&$warnings): void {
                $warnings++;
                $this->warn($message);
            },
        );

        ImportLog::record('legacy connection', $files, $warnings);

        $this->newLine();
        $pending = count(array_unique($files->uploads));
        $this->info(sprintf('Done. %d files copied, %d files pending, %d warnings.', $files->copied, $pending, $warnings));

        if ($pending > 0) {
            $this->line('Run `php artisan legacy:fetch-files` to download them from LEGACY_FILES_URL.');
        }

        return self::SUCCESS;
    }
}
