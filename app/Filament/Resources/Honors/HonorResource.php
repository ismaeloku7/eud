<?php

namespace App\Filament\Resources\Honors;

use App\Filament\Resources\Honors\Pages\CreateHonor;
use App\Filament\Resources\Honors\Pages\EditHonor;
use App\Filament\Resources\Honors\Pages\ListHonors;
use App\Filament\Resources\Honors\RelationManagers\PdfsRelationManager;
use App\Filament\Resources\Honors\Schemas\HonorForm;
use App\Filament\Resources\Honors\Tables\HonorsTable;
use App\Filament\Support\TranslatableResource;
use App\Models\Honor;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HonorResource extends TranslatableResource
{
    protected static ?string $model = Honor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Honors');
    }

    public static function getModelLabel(): string
    {
        return __('Honor');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Honors');
    }

    public static function form(Schema $schema): Schema
    {
        return HonorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HonorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PdfsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHonors::route('/'),
            'create' => CreateHonor::route('/create'),
            'edit' => EditHonor::route('/{record}/edit'),
        ];
    }
}
