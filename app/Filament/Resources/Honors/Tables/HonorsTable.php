<?php

namespace App\Filament\Resources\Honors\Tables;

use App\Filament\Support\Tables\Thumbnail;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HonorsTable
{
    public static function configure(Table $table): Table
    {
        $relationFilter = fn (string $name, string $relationship, string $label) => SelectFilter::make($name)
            ->label($label)
            ->relationship($relationship, 'name')
            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
            ->preload();

        return $table
            ->columns([
                Thumbnail::make('image')->circular(),
                TextColumn::make('name')->label(__('Name'))->searchable()->sortable()->wrap(),
                TextColumn::make('ministry.name')->label(__('Ministry'))->badge()->sortable(),
                TextColumn::make('category.name')->label(__('Category'))->sortable(),
                TextColumn::make('level.name')->label(__('Level'))->toggleable(),
                TextColumn::make('classHonor.name')->label(__('Class'))->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('masterAward.name')->label(__('Master award'))->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('pdfs_count')->label(__('PDFs'))->counts('pdfs')->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                $relationFilter('ministry', 'ministry', __('Ministry')),
                $relationFilter('category', 'category', __('Category')),
                $relationFilter('level', 'level', __('Level')),
                $relationFilter('classHonor', 'classHonor', __('Class')),
                $relationFilter('masterAward', 'masterAward', __('Master award')),
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
