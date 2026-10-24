<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Public URL of a stored file reference. New uploads are paths on the public
 * disk; legacy values may be absolute (/images/...) or full URLs.
 */
final class Media
{
    public static function url(?string $path, ?string $default = null): ?string
    {
        if ($path === null || trim($path) === '') {
            return $default ? asset($default) : null;
        }

        $path = trim($path);

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
