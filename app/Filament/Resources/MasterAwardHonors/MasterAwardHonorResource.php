<?php

namespace App\Filament\Resources\MasterAwardHonors;

use App\Filament\Resources\MasterAwardHonors\Pages\ManageMasterAwardHonors;
use App\Filament\Support\CatalogueResource;
use App\Models\MasterAwardHonor;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class MasterAwardHonorResource extends CatalogueResource
{
    protected static ?string $model = MasterAwardHonor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static ?int $navigationSort = 50;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Honors');
    }

    public static function getModelLabel(): string
    {
        return __('Master award');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Master awards');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMasterAwardHonors::route('/'),
        ];
    }
}
