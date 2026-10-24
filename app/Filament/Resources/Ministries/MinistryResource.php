<?php

namespace App\Filament\Resources\Ministries;

use App\Filament\Resources\Ministries\Pages\ManageMinistries;
use App\Filament\Support\CatalogueResource;
use App\Models\Ministry;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class MinistryResource extends CatalogueResource
{
    protected static ?string $model = Ministry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Content');
    }

    public static function getModelLabel(): string
    {
        return __('Ministry');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Ministries');
    }

    protected static function extraFormComponents(): array
    {
        return [
            TextInput::make('slug')
                ->label(__('Slug'))
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText(__('Part of the public URL. Changing it breaks existing links.'))
                ->dehydrateStateUsing(fn (?string $state): string => Str::slug((string) $state)),
            TextInput::make('counter')->label(__('Members counter'))->maxLength(50),
            TextInput::make('position')->label(__('Position'))->numeric()->default(0),
        ];
    }

    protected static function extraTableColumns(): array
    {
        return [
            TextColumn::make('slug')->label(__('Slug'))->searchable(),
            TextColumn::make('counter')->label(__('Members counter')),
            TextColumn::make('position')->label(__('Position'))->sortable(),
        ];
    }

    public static function table(Table $table): Table
    {
        return parent::table($table)->defaultSort('position')->reorderable('position');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMinistries::route('/'),
        ];
    }
}
