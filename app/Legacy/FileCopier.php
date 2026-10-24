<?php

namespace App\Legacy;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Rewrites legacy file references to paths on the public disk and, when the
 * previous site's folder is available, copies the files across.
 *
 * Legacy rule (convertUrlMigration): anything under images/ or video/ lived in
 * public/, everything else in storage/app/public.
 */
final class FileCopier
{
    /** @var array<string, string> target => missing source */
    public array $missing = [];

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
            $this->copy(['public/'.$path, 'storage/app/public/'.$path], $target = 'legacy/'.$path);

            return $target;
        }

        $this->copy(['storage/app/public/'.$path, 'public/'.$path], $path);

        return $path;
    }

    /** Media library files live in storage/app/public/{media id}/{file name}. */
    public function media(int $mediaId, string $fileName): void
    {
        $this->copy(["storage/app/public/{$mediaId}/{$fileName}"], "{$mediaId}/{$fileName}");
    }

    /** @param  array<int, string>  $candidates  relative to the legacy root, first existing wins */
    private function copy(array $candidates, string $target): void
    {
        if ($this->legacyRoot === null) {
            return;
        }

        $disk = Storage::disk('public');

        if ($disk->exists($target)) {
            return;
        }

        foreach ($candidates as $candidate) {
            $source = rtrim($this->legacyRoot, '/').'/'.$candidate;

            if (is_file($source)) {
                $disk->makeDirectory(dirname($target));
                copy($source, $disk->path($target));
                $this->copied++;

                return;
            }
        }

        $this->missing[$target] = $candidates[0];
    }
}
