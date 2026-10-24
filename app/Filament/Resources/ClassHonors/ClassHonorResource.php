<?php

namespace App\Filament\Resources\ClassHonors;

use App\Filament\Resources\ClassHonors\Pages\ManageClassHonors;
use App\Filament\Support\CatalogueResource;
use App\Models\ClassHonor;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ClassHonorResource extends CatalogueResource
{
    protected static ?string $model = ClassHonor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static ?int $navigationSort = 30;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Honors');
    }

    public static function getModelLabel(): string
    {
        return __('Class');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Classes');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageClassHonors::route('/'),
        ];
    }
}
