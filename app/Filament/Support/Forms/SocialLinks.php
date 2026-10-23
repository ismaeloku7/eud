<?php

namespace App\Filament\Support\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

/** Contact and social network fields shared by directors and offices. */
class SocialLinks
{
    public static function section(bool $withPhone = false): Section
    {
        return Section::make(__('Contact and social networks'))
            ->columns(2)
            ->collapsible()
            ->schema([
                TextInput::make('email')->label(__('Email'))->email()->maxLength(255),
                $withPhone
                    ? TextInput::make('phone')->label(__('Phone'))->tel()->maxLength(255)
                    : TextInput::make('address')->label(__('Address'))->maxLength(255),
                TextInput::make('website')->label(__('Website'))->maxLength(255),
                TextInput::make('website_2')->label(__('Second website'))->maxLength(255),
                TextInput::make('facebook')->label('Facebook')->maxLength(255),
                TextInput::make('instagram')->label('Instagram')->maxLength(255),
                TextInput::make('twitter')->label('X / Twitter')->maxLength(255),
                TextInput::make('youtube')->label('YouTube')->maxLength(255),
                TextInput::make('linkedin')->label('LinkedIn')->maxLength(255),
            ]);
    }
}
