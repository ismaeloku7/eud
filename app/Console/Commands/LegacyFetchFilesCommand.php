<?php

namespace App\Console\Commands;

use App\Legacy\FileCopier;
use App\Legacy\ImportLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Downloads, from the previous site, the uploaded files the import could not
 * copy. Started in the background by `site:setup`; safe to run again, it
 * skips files already present and keeps the rest pending.
 */
class LegacyFetchFilesCommand extends Command
{
    protected $signature = 'legacy:fetch-files {--max-seconds=0 : Stop after this many seconds (0 = no limit)}';

    protected $description = 'Download pending uploaded files from the previous site (LEGACY_FILES_URL)';

    public function handle(): int
    {
        $legacyUrl = config('site.legacy.files_url');

        if (! $legacyUrl) {
            $this->warn('LEGACY_FILES_URL is not set: nothing to download from.');

            return self::SUCCESS;
        }

        $lock = Cache::lock('legacy:fetch-files', 6 * 3600);

        if (! $lock->get()) {
            $this->info('Another download is already running.');

            return self::SUCCESS;
        }

        try {
            return $this->fetch($legacyUrl);
        } finally {
            $lock->release();
        }
    }

    private function fetch(string $legacyUrl): int
    {
        $pending = ImportLog::pending();
        $deadline = (int) $this->option('max-seconds') > 0 ? time() + (int) $this->option('max-seconds') : null;
        $disk = Storage::disk('public');
        $failed = [];
        $downloaded = 0;
        $processed = 0;

        foreach ($pending as $target) {
            if ($deadline !== null && time() >= $deadline) {
                break;
            }

            $processed++;

            if ($disk->exists($target)) {
                continue;
            }

            if (FileCopier::download($legacyUrl, $target)) {
                $downloaded++;
            } else {
                $failed[] = $target;
            }

            if ($processed % 25 === 0) {
                ImportLog::update($downloaded, [...$failed, ...array_slice($pending, $processed)]);
                $downloaded = 0;
            }
        }

        $stillPending = [...$failed, ...array_slice($pending, $processed)];
        ImportLog::update($downloaded, $stillPending);

        $this->info(sprintf('Done. %d files still pending.', count($stillPending)));

        return self::SUCCESS;
    }
}
