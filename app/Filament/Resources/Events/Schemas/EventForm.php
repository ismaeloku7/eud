<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Filament\Support\Forms\TemplateSchema;
use App\Filament\Support\Forms\Uploads;
use App\Pages\Field;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

/**
 * One screen per event. Every public tab of the event page has its own tab
 * here, with the label shown on the site editable next to its content.
 */
class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        $toolbar = ['bold', 'italic', 'underline', 'link', 'bulletList', 'orderedList', 'h2', 'h3', 'undo', 'redo'];

        return $schema
            ->columns(1)
            ->components([
                Tabs::make('event')
                    ->persistTabInQueryString('tab')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('general')->label(__('Event'))->schema([
                            Grid::make(3)->schema([
                                Section::make()->columnSpan(2)->columns(2)->schema([
                                    TextInput::make('title')
                                        ->label(__('Title'))
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (string $operation, ?string $state, Set $set, Get $get) => $operation === 'create' && blank($get('slug')) ? $set('slug', Str::slug((string) $state)) : null),
                                    TextInput::make('slug')
                                        ->label(__('Slug'))
                                        ->required()
                                        ->maxLength(255)
                                        ->helperText(__('Part of the public URL, one per language.')),
                                    TextInput::make('subtitle')->label(__('Subtitle'))->maxLength(255),
                                    TextInput::make('type')->label(__('Type'))->maxLength(255)->helperText(__('E.g. "Congress", "Camp".')),
                                    DateTimePicker::make('date_start')->label(__('Starts'))->required()->seconds(false),
                                    DateTimePicker::make('date_end')->label(__('Ends'))->required()->seconds(false)->after('date_start'),
                                    TextInput::make('slogan')->label(__('Slogan'))->maxLength(255),
                                    TextInput::make('tags')->label(__('Tags'))->maxLength(255)->helperText(__('Comma separated.')),
                                    Textarea::make('quote')->label(__('Quote'))->rows(2)->columnSpanFull(),
                                ]),
                                Grid::make(1)->columnSpan(1)->schema([
                                    Section::make(__('Publication'))->schema([
                                        Toggle::make('publish')->label(__('Published')),
                                    ]),
                                    Section::make(__('Images'))->schema([
                                        Uploads::image('photo_portada', 'events', __('Cover photo')),
                                        Uploads::image('facebook_banner', 'events', __('Social media banner')),
                                    ]),
                                ]),
                            ]),
                        ]),
                        Tab::make('about')->label(__('About'))->schema([
                            Section::make()->columns(2)->schema([
                                TextInput::make('about_tab')->label(__('Tab label'))->maxLength(100)->placeholder('About'),
                                TextInput::make('url_youtube')->label(__('YouTube video URL'))->url()->maxLength(2000),
                                RichEditor::make('description')->label(__('Description'))->toolbarButtons($toolbar)->columnSpanFull(),
                                Uploads::image('image_about', 'events', __('Image')),
                            ]),
                        ]),
                        Tab::make('speakers')->label(__('Speakers'))->schema([
                            Section::make()->columns(2)->schema([
                                TextInput::make('speaker_tab')->label(__('Tab label'))->maxLength(100)->placeholder('Speakers'),
                                TextInput::make('speaker_title')->label(__('Section title'))->maxLength(255),
                                Placeholder::make('speakers_hint')
                                    ->hiddenLabel()
                                    ->content(__('Speakers are added in the "Speakers" tab above, where you can also pick speakers from previous events.'))
                                    ->columnSpanFull(),
                            ]),
                        ]),
                        Tab::make('program')->label(__('Programme'))->schema([
                            Section::make()->columns(2)->schema([
                                TextInput::make('program_tab')->label(__('Tab label'))->maxLength(100)->placeholder('Programme'),
                                TextInput::make('program_title')->label(__('Section title'))->maxLength(255),
                                TextInput::make('program_subtitle')->label(__('Subtitle'))->maxLength(255),
                                TextInput::make('main_session_tab')->label(__('Main session tab label'))->maxLength(100)->placeholder('Main session'),
                                TextInput::make('main_session_title')->label(__('Main session title'))->maxLength(255),
                                RichEditor::make('program_description')->label(__('Description'))->toolbarButtons($toolbar)->columnSpanFull(),
                                Uploads::image('program_image', 'events', __('Programme image')),
                                Uploads::document('program_download', 'events/files', __('Programme PDF')),
                            ]),
                        ]),
                        Tab::make('workshops')->label(__('Workshops'))->schema([
                            Section::make()->columns(2)->schema([
                                TextInput::make('workshop_tab')->label(__('Tab label'))->maxLength(100)->placeholder('Workshops'),
                                TextInput::make('workshop_title')->label(__('Section title'))->maxLength(255),
                                RichEditor::make('workshop_description')->label(__('Description'))->toolbarButtons($toolbar)->columnSpanFull(),
                            ]),
                        ]),
                        Tab::make('location')->label(__('Location'))->schema([
                            Section::make()->columns(2)->schema([
                                TextInput::make('location_tab')->label(__('Tab label'))->maxLength(100)->placeholder('Location'),
                                TextInput::make('location_title')->label(__('Section title'))->maxLength(255),
                                TextInput::make('location')->label(__('Place'))->maxLength(255),
                                TextInput::make('location_url')->label(__('Map or venue link'))->url()->maxLength(2000),
                                TextInput::make('lat')->label(__('Latitude'))->maxLength(50),
                                TextInput::make('long')->label(__('Longitude'))->maxLength(50),
                                RichEditor::make('location_description')->label(__('Description'))->toolbarButtons($toolbar)->columnSpanFull(),
                                ...TemplateSchema::fields([
                                    Field::repeater('location_recursive', __('Information blocks'), [
                                        Field::text('title', __('Title')),
                                        Field::rich('content', __('Text')),
                                        Field::number('column', __('Column'), __('1 = full width, 2 = half width.')),
                                    ]),
                                ]),
                            ]),
                        ]),
                        Tab::make('registration')->label(__('Registration'))->schema([
                            Section::make()->columns(2)->schema([
                                Toggle::make('registration')->label(__('Registration open'))->columnSpanFull(),
                                TextInput::make('registration_tab')->label(__('Tab label'))->maxLength(100)->placeholder('Registration'),
                                TextInput::make('registration_title')->label(__('Section title'))->maxLength(255),
                                RichEditor::make('registration_eud')->label(__('Text for EUD participants'))->toolbarButtons($toolbar),
                                RichEditor::make('registration_non_eud')->label(__('Text for other participants'))->toolbarButtons($toolbar),
                                ...TemplateSchema::fields([
                                    Field::repeater('registration_recursive', __('Information blocks'), [
                                        Field::text('title', __('Title')),
                                        Field::rich('content', __('Text')),
                                        Field::number('column', __('Column'), __('1 = full width, 2 = half width.')),
                                    ]),
                                ]),
                            ]),
                        ]),
                        Tab::make('gallery')->label(__('Gallery'))->schema([
                            Section::make()->columns(2)->schema([
                                TextInput::make('gallery_tab')->label(__('Tab label'))->maxLength(100)->placeholder('Gallery'),
                                TextInput::make('gallery_title')->label(__('Section title'))->maxLength(255),
                                TextInput::make('url_gallery')->label(__('External gallery URL'))->url()->maxLength(2000),
                                TextInput::make('url_video')->label(__('Video URL'))->url()->maxLength(2000),
                                TextInput::make('playlist_video')->label(__('Playlist URL'))->url()->maxLength(2000),
                            ]),
                        ]),
                    ]),
            ]);
    }
}
