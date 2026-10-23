<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Filament\Support\Forms\TemplateSchema;
use App\Models\Page;
use App\Pages\Templates;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Content');
    }

    public static function getModelLabel(): string
    {
        return __('Page');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Pages');
    }

    public static function form(Schema $schema): Schema
    {
        $locales = config('app.supported_locales');

        return $schema
            ->columns(1)
            ->components([
                Section::make(__('Page'))
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(fn (string $operation): bool => $operation === 'edit')
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Internal name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, ?string $state, callable $set, Get $get) => $operation === 'create' && blank($get('slug')) ? $set('slug', Str::slug((string) $state)) : null),
                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText(__('Identifier used by the site. Do not change it for the built-in pages.')),
                        Select::make('template')
                            ->label(__('Template'))
                            ->options(Templates::options())
                            ->required()
                            ->live()
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->dehydrated(),
                        Fieldset::make(__('Browser title'))
                            ->columns(count($locales))
                            ->columnSpan(2)
                            ->schema(array_map(fn (string $locale) => TextInput::make("title.{$locale}")->label(strtoupper($locale))->maxLength(255), $locales)),
                        Toggle::make('published')->label(__('Published'))->default(true)->inline(false),
                        Fieldset::make(__('Search engine description'))
                            ->columns(count($locales))
                            ->columnSpanFull()
                            ->schema(array_map(fn (string $locale) => Textarea::make("seo.{$locale}")->label(strtoupper($locale))->rows(2)->maxLength(300), $locales)),
                    ]),
                Group::make()
                    ->schema(fn (Get $get): array => filled($get('template'))
                        ? [Group::make(TemplateSchema::components(Templates::find($get('template'))))->statePath('sections')]
                        : [])
                    ->key('template-sections'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                TextColumn::make('template')->label(__('Template'))->badge()->formatStateUsing(fn (string $state): string => Templates::options()[$state] ?? $state),
                TextColumn::make('slug')->label(__('Slug'))->color('gray'),
                IconColumn::make('published')->label(__('Published'))->boolean(),
                TextColumn::make('updated_at')->label(__('Updated'))->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
