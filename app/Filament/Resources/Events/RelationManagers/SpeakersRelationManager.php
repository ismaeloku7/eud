<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Support\Forms\Uploads;
use App\Filament\Support\Tables\Thumbnail;
use App\Models\Speaker;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\SpatieTranslatable\Resources\RelationManagers\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Tables\Actions\LocaleSwitcher;

/**
 * Speakers of an event. The speaker list is shared by all events, so a
 * speaker from a previous year can be added again instead of re-created.
 */
class SpeakersRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'speakers';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Speakers');
    }

    public static function getModelLabel(): string
    {
        return __('Speaker');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')->label(__('Name'))->required()->maxLength(255),
                TextInput::make('type')->label(__('Role'))->maxLength(255)->helperText(__('E.g. "Keynote speaker", "Workshop leader".')),
                Textarea::make('description')->label(__('Biography'))->rows(4)->columnSpanFull(),
                Uploads::image('photo', 'speakers', __('Photo'))->avatar()->imageEditor(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->description(__('Editing a speaker changes it in every event where it appears.'))
            ->columns([
                Thumbnail::make('photo')->circular(),
                TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                TextColumn::make('type')->label(__('Role'))->toggleable(),
                TextColumn::make('events.title')->label(__('Events'))->badge()->color('gray')->toggleable(),
            ])
            ->headerActions([
                LocaleSwitcher::make(),
                AttachAction::make()
                    ->label(__('Add existing speaker'))
                    ->modalHeading(__('Add a speaker from another event'))
                    ->preloadRecordSelect()
                    ->multiple()
                    ->recordSelectSearchColumns(['name', 'type'])
                    ->recordTitle(fn (Speaker $record): string => self::describe($record)),
                CreateAction::make()->label(__('New speaker')),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make()->label(__('Remove from event')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()->label(__('Remove from event')),
                ]),
            ]);
    }

    /** "Name · role · events" so a speaker can be recognised when picking from previous years. */
    private static function describe(Speaker $speaker): string
    {
        $events = $speaker->events->map(fn ($event): string => (string) $event->title)->filter()->join(', ');

        return collect([(string) $speaker->name, (string) $speaker->type, $events])->filter()->join(' · ');
    }
}
