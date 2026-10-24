<?php

namespace App\Pages;

abstract class Template
{
    abstract public static function key(): string;

    abstract public static function label(): string;

    /** @return array<int, Section> */
    abstract public function sections(): array;

    public function section(string $key): ?Section
    {
        foreach ($this->sections() as $section) {
            if ($section->key === $key) {
                return $section;
            }
        }

        return null;
    }
}
