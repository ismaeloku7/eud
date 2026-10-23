<?php

namespace App\Filament\Resources\Honors\RelationManagers;

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
use Illuminate\Support\Number;
use LaraZeus\SpatieTranslatable\Resources\RelationManagers\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Tables\Actions\LocaleSwitcher;

/** Requirement sheets (PDF) of an honor, one per language. */
class PdfsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'pdfs';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('PDF files');
    }

    public static function getModelLabel(): string
    {
        return __('PDF');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Relations::select('language_id', 'language', __('Language'))->required(),
                TextInput::make('name')->label(__('Name'))->maxLength(255),
                Uploads::document('file', 'honors/pdf', __('PDF'))->acceptedFileTypes(['application/pdf'])->required()->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file')
            ->columns([
                TextColumn::make('language.name')->label(__('Language'))->sortable(),
                TextColumn::make('name')->label(__('Name')),
                TextColumn::make('file')->label(__('File'))->limit(40)->url(fn ($record) => asset('storage/'.$record->file), shouldOpenInNewTab: true),
                TextColumn::make('size')->label(__('Size'))->formatStateUsing(fn ($state) => $state ? Number::fileSize((int) $state) : ''),
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
