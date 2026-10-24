<?php

namespace App\Filament\Support\Tables;

use App\Support\Media;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Model;

/** Table thumbnail that resolves uploads, legacy /images paths and full URLs alike. */
class Thumbnail
{
    public static function make(string $name): ImageColumn
    {
        return ImageColumn::make($name)
            ->label('')
            ->state(fn (Model $record): ?string => ($url = Media::url($record->{$name})) ? url($url) : null);
    }
}
