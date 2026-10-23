<?php

namespace App\Filament\Resources\Schedules;

use App\Filament\Resources\Schedules\Pages\ManageSchedules;
use App\Filament\Support\CatalogueResource;
use App\Models\Schedule;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

/** Time slots workshops can be scheduled into. */
class ScheduleResource extends CatalogueResource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?int $navigationSort = 40;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Events');
    }

    public static function getModelLabel(): string
    {
        return __('Time slot');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Time slots');
    }

    protected static function extraFormComponents(): array
    {
        return [
            DateTimePicker::make('date_start')->label(__('Starts'))->required()->seconds(false),
            DateTimePicker::make('date_end')->label(__('Ends'))->required()->seconds(false)->after('date_start'),
        ];
    }

    protected static function extraTableColumns(): array
    {
        return [
            TextColumn::make('date_start')->label(__('Starts'))->dateTime('d/m/Y H:i')->sortable(),
            TextColumn::make('date_end')->label(__('Ends'))->dateTime('H:i'),
        ];
    }

    public static function table(Table $table): Table
    {
        return parent::table($table)->defaultSort('date_start', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSchedules::route('/'),
        ];
    }
}
