<?php

namespace App\Filament\Resources\LevelHonors;

use App\Filament\Resources\LevelHonors\Pages\ManageLevelHonors;
use App\Filament\Support\CatalogueResource;
use App\Models\LevelHonor;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class LevelHonorResource extends CatalogueResource
{
    protected static ?string $model = LevelHonor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?int $navigationSort = 40;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Honors');
    }

    public static function getModelLabel(): string
    {
        return __('Level');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Levels');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageLevelHonors::route('/'),
        ];
    }
}
