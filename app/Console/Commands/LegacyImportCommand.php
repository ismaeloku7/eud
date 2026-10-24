<?php

namespace App\Console\Commands;

use App\Legacy\LegacyImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class LegacyImportCommand extends Command
{
    protected $signature = 'legacy:import
        {--only= : Comma separated step names to run (see --steps)}
        {--files= : Root folder of the previous site, to copy uploaded files (default LEGACY_FILES_PATH)}
        {--url= : Address of the previous site, to download uploaded files (default LEGACY_FILES_URL)}
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
        $legacyRoot = $this->option('files') ?: (env('LEGACY_FILES_PATH') ?: null);

        if ($legacyRoot && ! is_dir($legacyRoot)) {
            $this->error("Legacy files folder not found: {$legacyRoot}");

            return self::FAILURE;
        }

        $legacyUrl = $this->option('url') ?: (env('LEGACY_FILES_URL') ?: null);

        if (! $legacyRoot && ! $legacyUrl) {
            $this->warn('No legacy files folder or URL given: paths are rewritten but no file is copied.');
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
            $legacyUrl,
        );

        $this->newLine();
        $this->info(sprintf('Done. %d files copied, %d files missing, %d warnings.', $files->copied, count($files->missing), $warnings));

        foreach (array_slice($files->missing, 0, 20, true) as $target => $source) {
            $this->line("  missing: {$source}");
        }

        if (count($files->missing) > 20) {
            $this->line('  ... and '.(count($files->missing) - 20).' more');
        }

        return self::SUCCESS;
    }
}
