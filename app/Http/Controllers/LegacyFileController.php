<?php

namespace App\Http\Controllers;

use App\Legacy\FileCopier;
use App\Legacy\ImportLog;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Reached only when the web server finds no file under /storage. If it is an
 * upload of the previous site still waiting to be copied, it is downloaded
 * now, saved, and served; later requests get the file straight from disk.
 */
class LegacyFileController extends Controller
{
    public function __invoke(string $path): BinaryFileResponse
    {
        $disk = Storage::disk('public');

        abort_unless(FileCopier::isSafeTarget($path), 404);

        if (! $disk->exists($path)) {
            $legacyUrl = config('site.legacy.files_url');

            abort_unless($legacyUrl && ImportLog::isPending($path) && FileCopier::download($legacyUrl, $path), 404);
        }

        return response()->file($disk->path($path), ['Cache-Control' => 'public, max-age=31536000']);
    }
}
