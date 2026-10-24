<?php

namespace App\Legacy;

/** Normalises the loosely typed values stored by the previous site. */
final class Json
{
    public static function decode(mixed $value): mixed
    {
        if (! is_string($value)) {
            return $value;
        }

        $trimmed = trim($value);

        if ($trimmed === '') {
            return null;
        }

        $decoded = json_decode($trimmed, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }

    /** @return array<string, string>|null {locale: text}; plain strings become English. */
    public static function translatable(mixed $value): ?array
    {
        $decoded = self::decode($value);

        if ($decoded === null || $decoded === '' || $decoded === []) {
            return null;
        }

        if (is_array($decoded)) {
            if (array_is_list($decoded)) {
                return null;
            }

            $translations = [];

            foreach ($decoded as $locale => $text) {
                if (is_string($locale) && is_scalar($text) && trim((string) $text) !== '') {
                    $translations[$locale] = (string) $text;
                }
            }

            return $translations ?: null;
        }

        return ['en' => (string) $decoded];
    }

    /** English text of a translatable value, for columns that are plain strings now. */
    public static function plain(mixed $value): ?string
    {
        $translations = self::translatable($value);

        return $translations ? ($translations['en'] ?? reset($translations)) : null;
    }

    /** @return array<mixed>|null */
    public static function list(mixed $value): ?array
    {
        $decoded = self::decode($value);

        return is_array($decoded) ? $decoded : null;
    }

    public static function bool(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? false;
    }

    public static function int(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        $digits = preg_replace('/\D+/', '', (string) $value);

        return $digits === '' ? null : (int) $digits;
    }

    public static function encode(mixed $value): ?string
    {
        return $value === null ? null : json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
