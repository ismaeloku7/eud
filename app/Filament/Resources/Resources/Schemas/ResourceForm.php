<?php

namespace App\Filament\Resources\Resources\Schemas;

use App\Filament\Support\Forms\Relations;
use App\Filament\Support\Forms\Uploads;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(3)->schema([
                    Section::make(__('Resource'))
                        ->columnSpan(2)
                        ->columns(2)
                        ->schema([
                            TextInput::make('title')
                                ->label(__('Title'))
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $operation, ?string $state, Set $set, Get $get): void {
                                    if ($operation === 'create' && blank($get('slug'))) {
                                        $set('slug', Str::slug((string) $state));
                                    }
                                }),
                            TextInput::make('slug')
                                ->label(__('Slug'))
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->helperText(__('Part of the public URL. Changing it breaks existing links.')),
                            TextInput::make('subtitle')->label(__('Subtitle'))->maxLength(255),
                            TextInput::make('author')->label(__('Author'))->maxLength(255),
                            TextInput::make('legend')->label(__('Quote'))->maxLength(255),
                            TextInput::make('pages')->label(__('Pages'))->maxLength(50),
                            Textarea::make('intro')->label(__('Intro'))->rows(2)->columnSpanFull(),
                            RichEditor::make('description')
                                ->label(__('Description'))
                                ->toolbarButtons(['bold', 'italic', 'underline', 'link', 'bulletList', 'orderedList', 'h2', 'h3', 'blockquote', 'undo', 'redo'])
                                ->columnSpanFull(),
                        ]),
                    Grid::make(1)
                        ->columnSpan(1)
                        ->schema([
                            Section::make(__('Image'))->schema([
                                Uploads::image('image', 'resources')->hiddenLabel(),
                            ]),
                            Section::make(__('Options'))->schema([
                                Toggle::make('featured')->label(__('Featured on the home page')),
                                Toggle::make('collection')
                                    ->label(__('This is a collection'))
                                    ->helperText(__('A collection groups other resources instead of having its own files.'))
                                    ->live(),
                                TextInput::make('quantity')->label(__('Downloads'))->numeric()->default(0)->disabled()->dehydrated(false),
                            ]),
                        ]),
                ]),
                Section::make(__('Classification'))
                    ->columns(2)
                    ->schema([
                        Relations::multiple('ministries', __('Ministries')),
                        Relations::multiple('categories', __('Categories')),
                        Relations::multiple('related', __('Related resources'), 'title'),
                        Relations::multiple('items', __('Resources in this collection'), 'title')
                            ->visible(fn (Get $get): bool => (bool) $get('collection'))
                            ->helperText(__('Only resources that are not collections themselves.')),
                    ]),
            ]);
    }
}
