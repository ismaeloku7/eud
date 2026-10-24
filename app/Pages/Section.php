<?php

namespace App\Pages;

/** A tab in the page editor and a named group of values on the public page. */
final class Section
{
    /** @param  array<int, Field>  $fields */
    public function __construct(
        public readonly string $key,
        public readonly string $label,
        public readonly array $fields,
        public readonly ?string $description = null,
    ) {}
}
