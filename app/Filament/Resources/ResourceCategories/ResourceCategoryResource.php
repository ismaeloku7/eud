<?php

namespace App\Filament\Resources\ResourceCategories;

use App\Filament\Resources\ResourceCategories\Pages\ManageResourceCategories;
use App\Filament\Support\CatalogueResource;
use App\Models\CategoryResource as ResourceCategory;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;

class ResourceCategoryResource extends CatalogueResource
{
    protected static ?string $model = ResourceCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?int $navigationSort = 20;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Resources');
    }

    public static function getModelLabel(): string
    {
        return __('Resource category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Resource categories');
    }

    protected static function extraTableColumns(): array
    {
        return [
            TextColumn::make('resources_count')->label(__('Resources'))->counts('resources')->sortable(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageResourceCategories::route('/'),
        ];
    }
}
