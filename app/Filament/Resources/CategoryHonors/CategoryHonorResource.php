<?php

namespace App\Filament\Resources\CategoryHonors;

use App\Filament\Resources\CategoryHonors\Pages\ManageCategoryHonors;
use App\Filament\Support\CatalogueResource;
use App\Models\CategoryHonor;
use BackedEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;

class CategoryHonorResource extends CatalogueResource
{
    protected static ?string $model = CategoryHonor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSwatch;

    protected static ?int $navigationSort = 20;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Honors');
    }

    public static function getModelLabel(): string
    {
        return __('Honor category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Honor categories');
    }

    protected static function extraFormComponents(): array
    {
        return [
            ColorPicker::make('color')->label(__('Color'))->default('#6847c3'),
            TextInput::make('position')->label(__('Position'))->numeric()->default(0)
                ->helperText(__('Lower numbers are shown first.')),
        ];
    }

    protected static function extraTableColumns(): array
    {
        return [
            ColorColumn::make('color')->label(__('Color')),
            TextColumn::make('position')->label(__('Position'))->sortable(),
            TextColumn::make('honors_count')->label(__('Honors'))->counts('honors')->sortable(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCategoryHonors::route('/'),
        ];
    }
}
