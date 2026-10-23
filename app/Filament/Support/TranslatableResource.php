<?php

namespace App\Filament\Support;

use Filament\Resources\Resource;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

/**
 * Base for every resource whose model uses spatie/laravel-translatable.
 * Pages extending the classes in App\Filament\Support\Pages get a locale
 * switcher so the editor fills EN and ES on the same screen.
 */
abstract class TranslatableResource extends Resource
{
    use Translatable;
}
