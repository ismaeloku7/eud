<?php

namespace App\Pages;

use App\Pages\Templates\About;
use App\Pages\Templates\Amicus;
use App\Pages\Templates\Home;
use App\Pages\Templates\Ministry;
use App\Pages\Templates\Mission;
use App\Pages\Templates\SiteSettings;
use InvalidArgumentException;

/** Registry of the page templates the admin can create pages from. */
final class Templates
{
    /** @var array<int, class-string<Template>> */
    private const CLASSES = [
        Home::class,
        About::class,
        Mission::class,
        Ministry::class,
        Amicus::class,
        SiteSettings::class,
    ];

    /** @return array<string, Template> keyed by template key */
    public static function all(): array
    {
        $templates = [];

        foreach (self::CLASSES as $class) {
            $templates[$class::key()] = new $class;
        }

        return $templates;
    }

    /** @return array<string, string> key => label, for selects */
    public static function options(): array
    {
        return array_map(fn (Template $template) => $template::label(), self::all());
    }

    public static function find(string $key): Template
    {
        return self::all()[$key] ?? throw new InvalidArgumentException("Unknown page template [{$key}].");
    }
}
