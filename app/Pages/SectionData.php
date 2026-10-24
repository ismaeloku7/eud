<?php

namespace App\Pages;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/** Read-side view of one section, with locale fallback and URL resolution. */
final class SectionData
{
    /** @param  array<string, mixed>  $data */
    public function __construct(private readonly array $data) {}

    public function raw(string $field, mixed $default = null): mixed
    {
        return $this->data[$field] ?? $default;
    }

    public function has(string $field): bool
    {
        $value = $this->data[$field] ?? null;

        return is_array($value) ? Translate::resolve($value) !== '' || $this->isList($value) : filled($value);
    }

    /** Text in the current locale, falling back to English. */
    public function text(string $field, string $default = ''): string
    {
        $value = $this->data[$field] ?? null;

        return $value === null ? $default : Translate::resolve($value, $default);
    }

    /** Public URL of an uploaded image or file; legacy absolute paths pass through. */
    public function url(string $field): ?string
    {
        $path = $this->data[$field] ?? null;

        if (! is_string($path) || $path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    /** @return array<int, SectionData> */
    public function items(string $field): array
    {
        $items = $this->data[$field] ?? [];

        return array_values(array_map(fn ($item) => new self(is_array($item) ? $item : []), is_array($items) ? $items : []));
    }

    /** @return array<int, int> */
    public function ids(string $field): array
    {
        return array_values(array_map('intval', array_filter((array) ($this->data[$field] ?? []), 'is_numeric')));
    }

    private function isList(array $value): bool
    {
        return array_is_list($value) && $value !== [];
    }
}
