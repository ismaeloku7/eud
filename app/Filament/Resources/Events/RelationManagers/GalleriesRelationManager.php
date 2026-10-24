<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Support\Forms\Uploads;
use App\Filament\Support\Tables\Thumbnail;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/** Photo gallery of an event. */
class GalleriesRelationManager extends RelationManager
{
    protected static string $relationship = 'galleries';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Gallery');
    }

    public static function getModelLabel(): string
    {
        return __('Photo');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Uploads::image('image', 'events/gallery', __('Photo'))->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image')
            ->reorderable('position')
            ->defaultSort('position')
            ->columns([
                Thumbnail::make('image')->square()->size(80),
                TextColumn::make('image')->label(__('File'))->limit(60),
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
