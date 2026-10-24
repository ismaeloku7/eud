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
 * its relative path on the public disk and is copied from the old site's
 * folder ($legacyRoot) or downloaded from the old site ($legacyUrl).
 */
final class FileCopier
{
    /** @var array<string, string> target => missing source */
    public array $missing = [];

    public int $copied = 0;

    public function __construct(
        private readonly ?string $legacyRoot,
        private readonly ?string $legacyUrl = null,
    ) {}

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

        $this->bring($path, ['storage/app/public/'.$path, 'public/storage/'.$path], 'storage/'.$path);

        return $path;
    }

    /** Media library files live in storage/app/public/{media id}/{file name}. */
    public function media(int $mediaId, string $fileName): void
    {
        $this->bring("{$mediaId}/{$fileName}", ["storage/app/public/{$mediaId}/{$fileName}"], "storage/{$mediaId}/{$fileName}");
    }

    /**
     * @param  array<int, string>  $candidates  relative to the legacy root, first existing wins
     * @param  string  $urlPath  relative to the legacy site URL
     */
    private function bring(string $target, array $candidates, string $urlPath): void
    {
        if ($this->legacyRoot === null && $this->legacyUrl === null) {
            return;
        }

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

        if ($this->legacyUrl !== null) {
            try {
                $response = Http::timeout(30)->retry(2, 500, throw: false)->get(rtrim($this->legacyUrl, '/').'/'.implode('/', array_map('rawurlencode', explode('/', $urlPath))));

                if ($response->successful() && $response->body() !== '') {
                    $disk->put($target, $response->body());
                    $this->copied++;

                    return;
                }
            } catch (Throwable) {
                // Reported below as missing.
            }
        }

        $this->missing[$target] = $this->legacyUrl ? rtrim($this->legacyUrl, '/').'/'.$urlPath : $candidates[0];
    }
}
