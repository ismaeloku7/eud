<?php

namespace App\Console\Commands;

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
 * - Always: makes sure the fixed pages and the first admin user exist.
 */
class SiteSetupCommand extends Command
{
    /** Gzipped SQLite copy of the previous site's content, committed until the import is done. */
    public const BUNDLED_DUMP = 'database/legacy/legacy.sqlite.gz';

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

        $this->callSilently('db:seed', ['--class' => PageSeeder::class, '--force' => true]);
        $this->callSilently('db:seed', ['--class' => AdminUserSeeder::class, '--force' => true]);

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
                env('LEGACY_FILES_PATH') ?: null,
                true,
                fn (string $message) => $this->line($message),
                function (string $message) use (&$warnings): void {
                    $warnings++;
                    $this->warn($message);
                },
                env('LEGACY_FILES_URL') ?: null,
            );
        } finally {
            DB::purge('legacy');
            File::delete($database);
        }

        DB::table('legacy_imports')->insert([
            'source' => self::BUNDLED_DUMP,
            'files_copied' => $files->copied,
            'files_missing' => count($files->missing),
            'warnings' => $warnings,
            'missing' => json_encode(array_values($files->missing), JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->info(sprintf('Import finished: %d files copied, %d missing, %d warnings.', $files->copied, count($files->missing), $warnings));
    }
}
