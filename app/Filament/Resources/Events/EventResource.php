<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\RelationManagers\DownloadsRelationManager;
use App\Filament\Resources\Events\RelationManagers\GalleriesRelationManager;
use App\Filament\Resources\Events\RelationManagers\LinesRelationManager;
use App\Filament\Resources\Events\RelationManagers\LocalizationsRelationManager;
use App\Filament\Resources\Events\RelationManagers\ProgramsRelationManager;
use App\Filament\Resources\Events\RelationManagers\SchedulesRelationManager;
use App\Filament\Resources\Events\RelationManagers\SpeakersRelationManager;
use App\Filament\Resources\Events\RelationManagers\WorkshopsRelationManager;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Filament\Support\TranslatableResource;
use App\Models\Event;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventResource extends TranslatableResource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Events');
    }

    public static function getModelLabel(): string
    {
        return __('Event');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Events');
    }

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProgramsRelationManager::class,
            WorkshopsRelationManager::class,
            SpeakersRelationManager::class,
            SchedulesRelationManager::class,
            LinesRelationManager::class,
            LocalizationsRelationManager::class,
            GalleriesRelationManager::class,
            DownloadsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
