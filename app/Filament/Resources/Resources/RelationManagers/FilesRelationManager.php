<?php

namespace App\Filament\Resources\Resources\RelationManagers;

use App\Filament\Support\Forms\Relations;
use App\Filament\Support\Forms\Uploads;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/** Downloadable files of a resource, one per language and format. */
class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return ! $ownerRecord->collection;
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Files');
    }

    public static function getModelLabel(): string
    {
        return __('File');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Relations::select('language_id', 'language', __('Language'))->required(),
                Relations::select('type_file_id', 'type', __('File type')),
                Uploads::document('file', 'resources/files')->columnSpanFull()
                    ->helperText(__('Upload a file or paste an external link below.')),
                TextInput::make('url')->label(__('External link'))->url()->maxLength(2000)->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file')
            ->columns([
                TextColumn::make('language.name')->label(__('Language'))->sortable(),
                TextColumn::make('type.name')->label(__('Type'))->badge()->color('gray'),
                TextColumn::make('file')->label(__('File'))->limit(40)->url(fn ($record) => $record->file ? asset('storage/'.$record->file) : null, shouldOpenInNewTab: true),
                TextColumn::make('url')->label(__('External link'))->limit(40)->url(fn ($record) => $record->url, shouldOpenInNewTab: true)->toggleable(),
                TextColumn::make('size')->label(__('Size'))->formatStateUsing(fn ($record) => $record->humanSize()),
            ])
            ->headerActions([
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
