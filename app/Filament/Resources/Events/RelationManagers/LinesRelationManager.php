<?php

namespace App\Filament\Resources\Events\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\SpatieTranslatable\Resources\RelationManagers\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Tables\Actions\LocaleSwitcher;

/** Workshop tracks of this event, each with the colour used on the programme. */
class LinesRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'lines';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Workshop tracks');
    }

    public static function getModelLabel(): string
    {
        return __('Workshop track');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('title')->label(__('Title'))->required()->maxLength(255),
                ColorPicker::make('color')->label(__('Colour')),
                Textarea::make('description')->label(__('Description'))->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ColorColumn::make('color')->label(''),
                TextColumn::make('title')->label(__('Title'))->searchable()->sortable(),
                TextColumn::make('workshops_count')->label(__('Workshops'))->counts('workshops'),
            ])
            ->headerActions([
                LocaleSwitcher::make(),
                CreateAction::make(),
            ])
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
}
