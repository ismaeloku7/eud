<?php

namespace App\Filament\Resources\Speakers;

use App\Filament\Resources\Speakers\Pages\ManageSpeakers;
use App\Filament\Support\CatalogueResource;
use App\Filament\Support\Forms\Uploads;
use App\Models\Speaker;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SpeakerResource extends CatalogueResource
{
    protected static ?string $model = Speaker::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMicrophone;

    protected static ?int $navigationSort = 20;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Events');
    }

    public static function getModelLabel(): string
    {
        return __('Speaker');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Speakers');
    }

    protected static function extraFormComponents(): array
    {
        return [
            TextInput::make('type')->label(__('Role'))->maxLength(255)->helperText(__('E.g. "Keynote speaker", "Workshop leader".')),
            Textarea::make('description')->label(__('Biography'))->rows(4),
            Uploads::image('photo', 'speakers', __('Photo'))->avatar()->imageEditor(false),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->label('')->disk('public')->circular(),
                TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                TextColumn::make('type')->label(__('Role'))->toggleable(),
                TextColumn::make('events_count')->label(__('Events'))->counts('events')->sortable(),
                TextColumn::make('workshops_count')->label(__('Workshops'))->counts('workshops')->sortable()->toggleable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSpeakers::route('/'),
        ];
    }
}
