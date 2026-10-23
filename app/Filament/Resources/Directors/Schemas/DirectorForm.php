<?php

namespace App\Filament\Resources\Directors\Schemas;

use App\Filament\Support\Forms\Relations;
use App\Filament\Support\Forms\SocialLinks;
use App\Filament\Support\Forms\Uploads;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DirectorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(3)->schema([
                    Section::make(__('Person'))
                        ->columnSpan(2)
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')->label(__('Name'))->required()->maxLength(255),
                            TextInput::make('charge')->label(__('Position / role'))->maxLength(255)
                                ->helperText(__('Translatable, e.g. "Youth Director".')),
                            Relations::select('ministry_id', 'ministry', __('Ministry'))->required(),
                            Relations::select('country_id', 'country', __('Country'))->required(),
                            Relations::select('type_director_id', 'type', __('Director type')),
                            Textarea::make('description')->label(__('Description'))->rows(4)->columnSpanFull(),
                        ]),
                    Section::make(__('Photo'))
                        ->columnSpan(1)
                        ->schema([
                            Uploads::image('photo', 'directors', __('Photo'))->avatar()->imageEditor(false),
                        ]),
                ]),
                SocialLinks::section(),
            ]);
    }
}
