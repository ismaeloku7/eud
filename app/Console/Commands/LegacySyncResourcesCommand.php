<?php

namespace App\Console\Commands;

use App\Legacy\EudyouthResourceSync;
use App\Legacy\ImportLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Applies the eudyouth.org resources export: creates the missing resources and
 * copies the download counters. With --once (used by `site:setup`) it runs only
 * if that export was never applied, so later downloads are not overwritten.
 */
class LegacySyncResourcesCommand extends Command
{
    protected $signature = 'legacy:sync-resources
        {path? : JSON export, relative to the project (defaults to config site.legacy.resources_export)}
        {--once : Skip when this export was already applied}';

    protected $description = 'Create the resources missing from eudyouth.org and copy its download counters';

    public function handle(EudyouthResourceSync $sync): int
    {
        $source = (string) ($this->argument('path') ?: config('site.legacy.resources_export'));
        $path = str_starts_with($source, '/') ? $source : base_path($source);

        if ($source === '' || ! is_file($path)) {
            $this->error("Export not found: {$source}");

            return self::FAILURE;
        }

        if ($this->option('once') && DB::table('legacy_imports')->where('source', $source)->exists()) {
            return self::SUCCESS;
        }

        $result = $sync->run($path);

        ImportLog::recordQueued($source, $result['files'], count($result['missing_items']));

        foreach ($result['missing_items'] as $item) {
            $this->warn("Collection item not found: {$item}");
        }

        $this->info(sprintf(
            'eudyouth.org resources: %d created, %d counters updated, %d files to download.',
            count($result['created']),
            $result['counters'],
            count($result['files']),
        ));

        return self::SUCCESS;
    }
}
