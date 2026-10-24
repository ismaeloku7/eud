<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;

/**
 * The `legacy_imports` table: one row per finished import, holding the list
 * of uploaded files still to download from the previous site.
 */
final class ImportLog
{
    public static function record(string $source, FileCopier $files, int $warnings): void
    {
        $pending = array_values(array_unique($files->uploads));

        DB::table('legacy_imports')->insert([
            'source' => $source,
            'files_copied' => $files->copied,
            'files_missing' => count($pending),
            'warnings' => $warnings,
            'missing' => json_encode($pending, JSON_UNESCAPED_SLASHES),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        cache()->forget('legacy:pending-files');
    }

    /** @return object{id: int, files_copied: int, files_missing: int, missing: ?string}|null */
    public static function latest(): ?object
    {
        return DB::table('legacy_imports')->latest('id')->first();
    }

    /** @return array<int, string> */
    public static function pending(): array
    {
        $latest = self::latest();

        return $latest ? (json_decode((string) $latest->missing, true) ?: []) : [];
    }

    /** Pending files as a lookup set, cached for the public fallback route. */
    public static function isPending(string $target): bool
    {
        $set = cache()->remember('legacy:pending-files', 600, fn (): array => array_fill_keys(self::pending(), true));

        return isset($set[$target]);
    }

    /** @param  array<int, string>  $stillPending */
    public static function update(int $downloaded, array $stillPending): void
    {
        $latest = self::latest();

        if (! $latest) {
            return;
        }

        DB::table('legacy_imports')->where('id', $latest->id)->update([
            'files_copied' => $latest->files_copied + $downloaded,
            'files_missing' => count($stillPending),
            'missing' => json_encode(array_values($stillPending), JSON_UNESCAPED_SLASHES),
            'updated_at' => now(),
        ]);

        cache()->forget('legacy:pending-files');
    }
}
