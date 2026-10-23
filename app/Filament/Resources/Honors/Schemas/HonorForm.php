<?php

namespace App\Filament\Resources\Honors\Schemas;

use App\Filament\Support\Forms\Relations;
use App\Filament\Support\Forms\Uploads;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HonorForm
{
    public static function configure(Schema $schema): Schema
    {
        $toolbar = ['bold', 'italic', 'underline', 'link', 'bulletList', 'orderedList', 'h2', 'h3', 'undo', 'redo'];

        return $schema
            ->columns(1)
            ->components([
                Grid::make(3)->schema([
                    Section::make(__('Honor'))
                        ->columnSpan(2)
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')->label(__('Name'))->required()->maxLength(255)->columnSpanFull(),
                            Relations::select('ministry_id', 'ministry', __('Ministry'))->required(),
                            Relations::select('category_id', 'category', __('Category'))->required(),
                            Relations::select('class_id', 'classHonor', __('Class')),
                            Relations::select('level_id', 'level', __('Level')),
                            Relations::select('master_award_id', 'masterAward', __('Master award')),
                            TextInput::make('url')->label(__('External link'))->url()->maxLength(2000),
                        ]),
                    Section::make(__('Images'))
                        ->columnSpan(1)
                        ->schema([
                            Uploads::image('image', 'honors', __('Main image (patch)')),
                            Uploads::image('image_secondary', 'honors', __('Secondary image')),
                        ]),
                ]),
                Section::make(__('Content'))
                    ->schema([
                        RichEditor::make('description')->label(__('Description'))->toolbarButtons($toolbar),
                        RichEditor::make('requirements')->label(__('Requirements'))->toolbarButtons($toolbar),
                    ]),
            ]);
    }
}
