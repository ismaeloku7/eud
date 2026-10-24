<?php

namespace App\Filament\Resources\Events\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\SpatieTranslatable\Resources\RelationManagers\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Tables\Actions\LocaleSwitcher;

/** Time slots of this event, used to schedule its workshops. */
class SchedulesRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'schedules';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Time slots');
    }

    public static function getModelLabel(): string
    {
        return __('Time slot');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')->label(__('Name'))->required()->maxLength(255)->columnSpanFull(),
                DateTimePicker::make('date_start')->label(__('Starts'))->required()->seconds(false),
                DateTimePicker::make('date_end')->label(__('Ends'))->required()->seconds(false)->after('date_start'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('date_start')
            ->columns([
                TextColumn::make('name')->label(__('Name'))->searchable(),
                TextColumn::make('date_start')->label(__('Starts'))->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('date_end')->label(__('Ends'))->dateTime('H:i'),
                TextColumn::make('workshop_schedules_count')->label(__('Workshops'))->counts('workshopSchedules'),
            ])
            ->headerActions([
                LocaleSwitcher::make(),
                CreateAction::make(),
            ])
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
}
