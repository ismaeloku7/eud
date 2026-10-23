<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Support\Forms\Uploads;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\SpatieTranslatable\Resources\RelationManagers\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Tables\Actions\LocaleSwitcher;

/** Documents offered for download on the event page. */
class DownloadsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'downloads';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Downloads');
    }

    public static function getModelLabel(): string
    {
        return __('Download');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')->label(__('Name'))->required()->maxLength(255),
                Select::make('language')->label(__('Language'))->options(fn (): array => collect(config('app.supported_locales'))->mapWithKeys(fn (string $locale) => [$locale => strtoupper($locale)])->all()),
                Uploads::document('document', 'events/files', __('File'))->required()->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->label(__('Name'))->searchable(),
                TextColumn::make('language')->label(__('Language'))->badge()->formatStateUsing(fn (?string $state) => strtoupper((string) $state)),
                TextColumn::make('document')->label(__('File'))->limit(50)->url(fn ($record) => asset('storage/'.$record->document), shouldOpenInNewTab: true),
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
