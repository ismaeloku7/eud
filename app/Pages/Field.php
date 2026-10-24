<?php

namespace App\Pages;

/**
 * One editable value inside a page section. Translatable fields store
 * {locale: value}; the rest store a scalar (path, colour, number, ids...).
 */
final class Field
{
    /** @param  array<int, Field>  $children */
    private function __construct(
        public readonly string $key,
        public readonly string $label,
        public readonly FieldType $type,
        public readonly bool $translatable = false,
        public readonly ?string $help = null,
        public readonly array $children = [],
        public readonly ?int $max = null,
    ) {}

    public static function text(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Text, translatable: true, help: $help);
    }

    public static function textarea(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Textarea, translatable: true, help: $help);
    }

    public static function rich(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Rich, translatable: true, help: $help);
    }

    public static function image(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Image, help: $help);
    }

    public static function file(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::File, help: $help);
    }

    public static function color(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Color, help: $help);
    }

    public static function number(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Number, help: $help);
    }

    public static function url(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Url, help: $help);
    }

    /** A list of resource ids picked from the Resources catalogue. */
    public static function resources(string $key, string $label, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Resources, help: $help);
    }

    /** @param  array<int, Field>  $children */
    public static function repeater(string $key, string $label, array $children, ?int $max = null, ?string $help = null): self
    {
        return new self($key, $label, FieldType::Repeater, help: $help, children: $children, max: $max);
    }
}
