<?php

namespace App\Console\Commands;

use App\Legacy\ImportLog;
use App\Legacy\LegacyImporter;
use App\Models\Ministry;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\CatalogueSeeder;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\PageSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Runs on every deploy (see the Forge deploy script) and is safe to repeat:
 *
 * - First deploy with the bundled legacy dump: imports the previous site once.
 * - First deploy without it: seeds catalogues and ministries.
 * - Once: applies the eudyouth.org resources export (new resources, download counters).
 * - Always: makes sure the fixed pages and the first admin user exist.
 */
class SiteSetupCommand extends Command
{
    /** Gzipped SQLite copy of the previous site's content, committed until the import is done. */
    public const BUNDLED_DUMP = 'database/legacy/legacy-content.db.gz';

    protected $signature = 'site:setup';

    protected $description = 'Prepare the site after a deploy: one-time import of the previous site, fixed pages and first admin';

    public function handle(LegacyImporter $importer): int
    {
        if ($this->shouldImport()) {
            $this->importBundledDump($importer);
        } elseif (Ministry::query()->doesntExist()) {
            $this->info('Empty database: seeding catalogues and ministries.');
            $this->callSilently('db:seed', ['--class' => CatalogueSeeder::class, '--force' => true]);
            $this->callSilently('db:seed', ['--class' => MinistrySeeder::class, '--force' => true]);
        }

        if (config('site.legacy.resources_export')) {
            $this->call('legacy:sync-resources', ['--once' => true]);
        }

        $this->callSilently('db:seed', ['--class' => PageSeeder::class, '--force' => true]);
        $this->callSilently('db:seed', ['--class' => AdminUserSeeder::class, '--force' => true]);

        $this->startFileDownloads();

        $this->info('Site ready.');

        return self::SUCCESS;
    }

    private function shouldImport(): bool
    {
        return File::exists(base_path(self::BUNDLED_DUMP)) && DB::table('legacy_imports')->doesntExist();
    }

    private function importBundledDump(LegacyImporter $importer): void
    {
        $this->info('Importing the previous site (first deploy only)...');

        $database = storage_path('app/legacy-import.sqlite');
        File::put($database, gzdecode(File::get(base_path(self::BUNDLED_DUMP))));

        config()->set('database.connections.legacy', [
            'driver' => 'sqlite',
            'database' => $database,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);
        DB::purge('legacy');

        $warnings = 0;

        try {
            $files = $importer->run(
                [],
                config('site.legacy.files_path') ?: null,
                true,
                fn (string $message) => $this->line($message),
                function (string $message) use (&$warnings): void {
                    $warnings++;
                    $this->warn($message);
                },
            );
        } finally {
            DB::purge('legacy');
            File::delete($database);
        }

        ImportLog::record(self::BUNDLED_DUMP, $files, $warnings);

        $this->info(sprintf('Import finished: %d files copied, %d to download in the background, %d warnings.', $files->copied, count(array_unique($files->uploads)), $warnings));
    }

    /**
     * Downloads of the previous site's uploads take longer than Forge allows
     * for a deploy, so they run in a detached process that outlives it.
     */
    private function startFileDownloads(): void
    {
        if (! config('site.legacy.files_url') || ImportLog::pending() === [] || app()->runningUnitTests()) {
            return;
        }

        $command = sprintf(
            '%s %s legacy:fetch-files',
            escapeshellarg(PHP_BINARY),
            escapeshellarg(base_path('artisan')),
        );

        // Close every inherited descriptor above stderr before detaching: Forge's
        // deploy waits until all handles to its output are closed.
        exec(sprintf(
            'sh -c %s > %s 2>&1 < /dev/null &',
            escapeshellarg('for fd in $(ls /proc/$$/fd); do [ "$fd" -gt 2 ] && eval "exec $fd>&-"; done; exec setsid '.$command),
            escapeshellarg(storage_path('logs/legacy-files.log')),
        ));

        $this->info(sprintf('Downloading %d files from the previous site in the background.', count(ImportLog::pending())));
    }
}
