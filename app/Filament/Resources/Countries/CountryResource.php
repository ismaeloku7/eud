<?php

namespace App\Filament\Resources\Countries;

use App\Filament\Resources\Countries\Pages\ManageCountries;
use App\Filament\Support\CatalogueResource;
use App\Filament\Support\Forms\Relations;
use App\Filament\Support\Forms\Uploads;
use App\Filament\Support\Tables\Thumbnail;
use App\Models\Country;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class CountryResource extends CatalogueResource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeEuropeAfrica;

    protected static ?int $navigationSort = 20;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Directory');
    }

    public static function getModelLabel(): string
    {
        return __('Country');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Countries');
    }

    protected static function extraFormComponents(): array
    {
        return [
            Relations::select('country_id', 'parent', __('Belongs to (union)'))
                ->relationship(
                    'parent',
                    'name',
                    modifyQueryUsing: fn (Builder $query, ?Country $record) => $record ? $query->whereKeyNot($record->getKey()) : $query,
                )
                ->helperText(__('Leave empty for a union or a country shown on its own.')),
            Uploads::image('image', 'countries', __('Flag or map image')),
        ];
    }

    protected static function extraTableColumns(): array
    {
        return [
            Thumbnail::make('image')->circular(),
            TextColumn::make('parent.name')->label(__('Belongs to'))->sortable()->toggleable(),
            TextColumn::make('directors_count')->label(__('Directors'))->counts('directors')->sortable(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCountries::route('/'),
        ];
    }
}
