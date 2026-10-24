<?php

namespace App\Pages;

/** Resolves {locale: text} values the way the public site expects. */
final class Translate
{
    public static function resolve(mixed $value, string $default = ''): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (! is_array($value)) {
            return $default;
        }

        $locale = app()->getLocale();

        foreach ([$locale, config('app.fallback_locale'), ...array_keys($value)] as $candidate) {
            $text = $value[$candidate] ?? null;

            if (is_string($text) && trim($text) !== '') {
                return $text;
            }
        }

        return $default;
    }
}
