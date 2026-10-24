<?php

namespace App\Legacy;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Rewrites legacy file references and brings the uploaded files across.
 *
 * Legacy rule (convertUrlMigration): anything under images/ or video/ lived in
 * the old public/ folder and ships with this repository, so it keeps its
 * absolute path. Everything else was an upload in storage/app/public: it keeps
 * its relative path on the public disk. During the import such files are only
 * copied when the old site's folder is on this server ($legacyRoot); the ones
 * still missing are listed in $uploads and downloaded later (see
 * `legacy:fetch-files` and LegacyFileController), because downloading during
 * a deploy would exceed Forge's time limit.
 */
final class FileCopier
{
    /** @var array<int, string> uploaded files referenced by the content and not on the public disk yet */
    public array $uploads = [];

    public int $copied = 0;

    public function __construct(private readonly ?string $legacyRoot) {}

    public function path(mixed $value): ?string
    {
        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        $path = ltrim($value, '/');
        $path = Str::startsWith($path, 'storage/') ? Str::after($path, 'storage/') : $path;
        $path = Str::startsWith($path, 'public/') ? Str::after($path, 'public/') : $path;

        if (Str::contains($path, ['images/', 'video/'])) {
            return '/'.$path;
        }

        $this->bring($path, ['storage/app/public/'.$path, 'public/storage/'.$path]);

        return $path;
    }

    /** Media library files live in storage/app/public/{media id}/{file name}. */
    public function media(int $mediaId, string $fileName): void
    {
        $this->bring("{$mediaId}/{$fileName}", ["storage/app/public/{$mediaId}/{$fileName}"]);
    }

    /**
     * Downloads one uploaded file from the previous site into the public disk.
     */
    public static function download(string $legacyUrl, string $target, int $timeout = 20): bool
    {
        if (! self::isSafeTarget($target)) {
            return false;
        }

        try {
            $url = rtrim($legacyUrl, '/').'/storage/'.implode('/', array_map('rawurlencode', explode('/', $target)));
            $response = Http::connectTimeout(5)->timeout($timeout)->get($url);

            if ($response->successful() && $response->body() !== '') {
                Storage::disk('public')->put($target, $response->body());

                return true;
            }
        } catch (Throwable) {
            // The caller reports the file as still missing.
        }

        return false;
    }

    /** Relative path inside the public disk, without traversal or hidden segments. */
    public static function isSafeTarget(string $target): bool
    {
        return $target !== ''
            && ! str_starts_with($target, '/')
            && ! str_contains($target, '\\')
            && collect(explode('/', $target))->every(fn (string $segment): bool => $segment !== '' && ! str_starts_with($segment, '.'));
    }

    /** @param  array<int, string>  $candidates  relative to the legacy root, first existing wins */
    private function bring(string $target, array $candidates): void
    {
        $disk = Storage::disk('public');

        if ($disk->exists($target)) {
            return;
        }

        foreach ($this->legacyRoot ? $candidates : [] as $candidate) {
            $source = rtrim($this->legacyRoot, '/').'/'.$candidate;

            if (is_file($source)) {
                $disk->put($target, file_get_contents($source));
                $this->copied++;

                return;
            }
        }

        $this->uploads[] = $target;
    }
}
