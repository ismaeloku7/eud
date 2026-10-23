<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Support\Forms\Relations;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\SpatieTranslatable\Resources\RelationManagers\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Tables\Actions\LocaleSwitcher;

/** Programme entries (plenaries, meals, main sessions) of an event. */
class ProgramsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'programs';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Programme');
    }

    public static function getModelLabel(): string
    {
        return __('Programme entry');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')->label(__('Title'))->required()->maxLength(255)->columnSpanFull(),
                DateTimePicker::make('date_start')->label(__('Starts'))->required()->seconds(false),
                DateTimePicker::make('date_end')->label(__('Ends'))->required()->seconds(false)->after('date_start'),
                ColorPicker::make('color')->label(__('Colour')),
                Relations::multiple('speakers', __('Speakers')),
                Toggle::make('main_session')->label(__('Main session')),
                Toggle::make('sync_workshop')->label(__('Workshop slot'))->helperText(__('Show the workshops scheduled at this time.')),
                RichEditor::make('description')->label(__('Description'))->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'undo', 'redo'])->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('date_start')->label(__('Starts'))->dateTime('d/m H:i')->sortable(),
                TextColumn::make('date_end')->label(__('Ends'))->dateTime('H:i'),
                ColorColumn::make('color')->label(''),
                TextColumn::make('title')->label(__('Title'))->searchable()->wrap(),
                TextColumn::make('speakers.name')->label(__('Speakers'))->badge()->toggleable(),
                IconColumn::make('main_session')->label(__('Main session'))->boolean(),
                IconColumn::make('sync_workshop')->label(__('Workshops'))->boolean(),
            ])
            ->defaultSort('date_start')
            ->headerActions([
                LocaleSwitcher::make(),
                CreateAction::make()->modalWidth('3xl'),
            ])
            ->recordActions([
                EditAction::make()->modalWidth('3xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
