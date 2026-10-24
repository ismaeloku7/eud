<?php

namespace App\Filament\Support\Forms;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;

/** Selects for BelongsTo / BelongsToMany whose related "name" is translatable. */
class Relations
{
    public static function select(string $field, string $relationship, string $label, string $titleAttribute = 'name'): Select
    {
        return Select::make($field)
            ->label($label)
            ->relationship($relationship, $titleAttribute)
            ->getOptionLabelFromRecordUsing(fn (Model $record): string => (string) $record->{$titleAttribute})
            ->searchable()
            ->preload();
    }

    public static function multiple(string $relationship, string $label, string $titleAttribute = 'name'): Select
    {
        return static::select($relationship, $relationship, $label, $titleAttribute)->multiple();
    }
}
