<?php

namespace App\Filament\Resources\Resources\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ResourcesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('')->disk('public')->square(),
                TextColumn::make('title')->label(__('Title'))->searchable()->sortable()->wrap()->description(fn ($record) => $record->author),
                TextColumn::make('ministries.name')->label(__('Ministries'))->badge()->toggleable(),
                TextColumn::make('categories.name')->label(__('Categories'))->badge()->color('gray')->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('collection')->label(__('Collection'))->boolean()->toggleable(),
                IconColumn::make('featured')->label(__('Featured'))->boolean(),
                TextColumn::make('files_count')->label(__('Files'))->counts('files')->sortable(),
                TextColumn::make('quantity')->label(__('Downloads'))->numeric()->sortable(),
                TextColumn::make('updated_at')->label(__('Updated'))->dateTime('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                SelectFilter::make('ministries')->label(__('Ministry'))->relationship('ministries', 'name')->getOptionLabelFromRecordUsing(fn ($record) => $record->name)->preload(),
                SelectFilter::make('categories')->label(__('Category'))->relationship('categories', 'name')->getOptionLabelFromRecordUsing(fn ($record) => $record->name)->preload(),
                TernaryFilter::make('collection')->label(__('Collection')),
                TernaryFilter::make('featured')->label(__('Featured')),
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
