<?php

namespace App\Filament\Resources\Lines;

use App\Filament\Resources\Lines\Pages\ManageLines;
use App\Filament\Support\TranslatableResource;
use App\Models\Line;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

/** Workshop tracks, each with a colour used on the programme grid. */
class LineResource extends TranslatableResource
{
    protected static ?string $model = Line::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSwatch;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 30;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Events');
    }

    public static function getModelLabel(): string
    {
        return __('Workshop track');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Workshop tracks');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('title')->label(__('Title'))->required()->maxLength(255),
                ColorPicker::make('color')->label(__('Colour')),
                Textarea::make('description')->label(__('Description'))->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')->label(''),
                TextColumn::make('title')->label(__('Title'))->searchable()->sortable(),
                TextColumn::make('workshops_count')->label(__('Workshops'))->counts('workshops')->sortable(),
            ])
            ->defaultSort('title')
            ->recordActions([
                EditAction::make(),
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
            'index' => ManageLines::route('/'),
        ];
    }
}
