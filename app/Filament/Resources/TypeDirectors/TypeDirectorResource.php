<?php

namespace App\Filament\Resources\TypeDirectors;

use App\Filament\Resources\TypeDirectors\Pages\ManageTypeDirectors;
use App\Filament\Support\CatalogueResource;
use App\Models\TypeDirector;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class TypeDirectorResource extends CatalogueResource
{
    protected static ?string $model = TypeDirector::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static ?int $navigationSort = 40;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Directory');
    }

    public static function getModelLabel(): string
    {
        return __('Director type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Director types');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTypeDirectors::route('/'),
        ];
    }
}
