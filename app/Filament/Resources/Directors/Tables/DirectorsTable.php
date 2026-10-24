<?php

namespace App\Filament\Resources\Directors\Tables;

use App\Filament\Support\Tables\Thumbnail;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DirectorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Thumbnail::make('photo')->circular(),
                TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                TextColumn::make('charge')->label(__('Position / role'))->searchable()->toggleable(),
                TextColumn::make('ministry.name')->label(__('Ministry'))->badge()->sortable(),
                TextColumn::make('country.name')->label(__('Country'))->sortable(),
                TextColumn::make('type.name')->label(__('Type'))->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')->label(__('Email'))->searchable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('ministry')->label(__('Ministry'))->relationship('ministry', 'name')->getOptionLabelFromRecordUsing(fn ($record) => $record->name)->preload(),
                SelectFilter::make('country')->label(__('Country'))->relationship('country', 'name')->getOptionLabelFromRecordUsing(fn ($record) => $record->name)->preload()->searchable(),
                SelectFilter::make('type')->label(__('Type'))->relationship('type', 'name')->getOptionLabelFromRecordUsing(fn ($record) => $record->name)->preload(),
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
