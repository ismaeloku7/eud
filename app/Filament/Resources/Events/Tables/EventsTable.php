<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_portada')->label('')->disk('public')->square(),
                TextColumn::make('title')->label(__('Title'))->searchable()->sortable()->wrap()->description(fn ($record) => $record->subtitle),
                TextColumn::make('date_start')->label(__('Starts'))->date('d/m/Y')->sortable(),
                TextColumn::make('date_end')->label(__('Ends'))->date('d/m/Y')->sortable()->toggleable(),
                TextColumn::make('type')->label(__('Type'))->badge()->color('gray')->toggleable(),
                IconColumn::make('publish')->label(__('Published'))->boolean(),
                IconColumn::make('registration')->label(__('Registration'))->boolean()->toggleable(),
                TextColumn::make('workshops_count')->label(__('Workshops'))->counts('workshops')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date_start', 'desc')
            ->filters([
                TernaryFilter::make('publish')->label(__('Published')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
