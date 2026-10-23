<?php

namespace App\Filament\Resources\Directors;

use App\Filament\Resources\Directors\Pages\CreateDirector;
use App\Filament\Resources\Directors\Pages\EditDirector;
use App\Filament\Resources\Directors\Pages\ListDirectors;
use App\Filament\Resources\Directors\Schemas\DirectorForm;
use App\Filament\Resources\Directors\Tables\DirectorsTable;
use App\Filament\Support\TranslatableResource;
use App\Models\Director;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DirectorResource extends TranslatableResource
{
    protected static ?string $model = Director::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Directory');
    }

    public static function getModelLabel(): string
    {
        return __('Director');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Directors');
    }

    public static function form(Schema $schema): Schema
    {
        return DirectorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DirectorsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDirectors::route('/'),
            'create' => CreateDirector::route('/create'),
            'edit' => EditDirector::route('/{record}/edit'),
        ];
    }
}
