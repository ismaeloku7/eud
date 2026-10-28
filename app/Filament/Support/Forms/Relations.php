<?php

namespace App\Filament\Support\Forms;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Selects for BelongsTo / BelongsToMany whose related "name" is translatable.
 *
 * The title attribute is a JSON column, so Filament's own option loading
 * returns rows unsorted, capped at 50, and searches the raw JSON (where
 * accents are escaped). Options are instead labelled in the current locale,
 * then sorted and filtered in PHP, ignoring case and accents.
 */
class Relations
{
    public static function select(string $field, string $relationship, string $label, string $titleAttribute = 'name'): Select
    {
        return Select::make($field)
            ->label($label)
            ->relationship($relationship, $titleAttribute)
            ->getOptionLabelFromRecordUsing(fn (Model $record): string => (string) $record->{$titleAttribute})
            ->options(fn (Select $component): array => static::options($component))
            ->getSearchResultsUsing(fn (Select $component, ?string $search): array => static::options($component, $search))
            ->searchable()
            ->preload();
    }

    public static function multiple(string $relationship, string $label, string $titleAttribute = 'name'): Select
    {
        return static::select($relationship, $relationship, $label, $titleAttribute)->multiple();
    }

    /**
     * Every related record as [key => label], alphabetically, optionally
     * narrowed to the labels containing the search term.
     *
     * @return array<int|string, string>
     */
    public static function options(Select $component, ?string $search = null): array
    {
        $needle = static::normalize((string) $search);

        return $component->getRelationship()->getRelated()->newQuery()->get()
            ->mapWithKeys(fn (Model $record): array => [$record->getKey() => $component->getOptionLabelFromRecord($record)])
            ->filter(fn (string $label): bool => $needle === '' || str_contains(static::normalize($label), $needle))
            ->sortBy(fn (string $label): string => static::normalize($label))
            ->all();
    }

    /** Lower-cased ASCII form of a label, so "Búlgaro" matches "bulgaro" and sorts with the B's. */
    protected static function normalize(string $value): string
    {
        return Str::lower(Str::ascii(trim($value)));
    }
}
