<?php

namespace App\Filament\Support\Forms;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Selects for BelongsTo / BelongsToMany whose related "name" is translatable.
 *
 * Searching is done in the browser over the translated labels: with no search
 * columns Filament preloads every record instead of the first 50 and does not
 * run a LIKE on the JSON column, which on MySQL is case-sensitive and never
 * matches accented text because translations are stored escaped.
 */
class Relations
{
    public static function select(string $field, string $relationship, string $label, string $titleAttribute = 'name'): Select
    {
        return Select::make($field)
            ->label($label)
            ->relationship(
                $relationship,
                $titleAttribute,
                fn (Builder $query): Builder => static::orderByTranslatedTitle($query, $titleAttribute),
            )
            ->getOptionLabelFromRecordUsing(fn (Model $record): string => (string) $record->{$titleAttribute})
            ->searchable([])
            ->preload()
            ->optionsLimit(500);
    }

    public static function multiple(string $relationship, string $label, string $titleAttribute = 'name'): Select
    {
        return static::select($relationship, $relationship, $label, $titleAttribute)->multiple();
    }

    /**
     * Alphabetical order by the title in the current locale. Rows without that
     * translation are placed by their fallback-locale title, the same one the
     * option label shows, instead of being listed first as empty values.
     */
    protected static function orderByTranslatedTitle(Builder $query, string $titleAttribute): Builder
    {
        $grammar = $query->getQuery()->getGrammar();
        $column = $query->qualifyColumn($titleAttribute);

        $current = $grammar->wrap("{$column}->".app()->getLocale());
        $fallback = $grammar->wrap("{$column}->".config('app.fallback_locale'));

        return $query->orderByRaw("coalesce({$current}, {$fallback})");
    }
}
