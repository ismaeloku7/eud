<?php

namespace App\Filament\Resources\OfficeGenerals;

use App\Filament\Resources\OfficeGenerals\Pages\ManageOfficeGenerals;
use App\Filament\Support\Forms\Relations;
use App\Filament\Support\Forms\SocialLinks;
use App\Filament\Support\TranslatableResource;
use App\Models\OfficeGeneral;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class OfficeGeneralResource extends TranslatableResource
{
    protected static ?string $model = OfficeGeneral::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 30;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Directory');
    }

    public static function getModelLabel(): string
    {
        return __('Office');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Offices');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')->label(__('Title'))->required()->maxLength(255),
                        Relations::select('country_id', 'country', __('Country'))->required(),
                        TextInput::make('address')->label(__('Address'))->maxLength(255)->columnSpanFull(),
                        Textarea::make('description')->label(__('Description'))->rows(3)->columnSpanFull(),
                    ]),
                SocialLinks::section(withPhone: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label(__('Title'))->searchable()->sortable(),
                TextColumn::make('country.name')->label(__('Country'))->sortable(),
                TextColumn::make('email')->label(__('Email'))->searchable()->toggleable(),
                TextColumn::make('phone')->label(__('Phone'))->toggleable(),
            ])
            ->defaultSort('title')
            ->filters([
                SelectFilter::make('country')->label(__('Country'))->relationship('country', 'name')->getOptionLabelFromRecordUsing(fn ($record) => $record->name)->preload(),
            ])
            ->recordActions([
                EditAction::make()->modalWidth('4xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageOfficeGenerals::route('/'),
        ];
    }
}
