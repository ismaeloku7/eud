<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Support\Forms\Relations;
use App\Models\Localization;
use App\Models\Schedule;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\SpatieTranslatable\Resources\RelationManagers\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Tables\Actions\LocaleSwitcher;

/** Workshops of an event, with their speakers and the slots/rooms where they repeat. */
class WorkshopsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'workshops';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Workshops');
    }

    public static function getModelLabel(): string
    {
        return __('Workshop');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')->label(__('Title'))->required()->maxLength(255)->columnSpanFull(),
                Relations::select('line_id', 'line', __('Track'), 'title'),
                TextInput::make('video_url')->label(__('Video URL'))->url()->maxLength(2000),
                Relations::multiple('speakers', __('Speakers')),
                Toggle::make('collection')->label(__('Main session'))->inline(false),
                RichEditor::make('description')->label(__('Description'))->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'undo', 'redo'])->columnSpanFull(),
                Repeater::make('schedules')
                    ->label(__('When and where'))
                    ->relationship()
                    ->columns(2)
                    ->defaultItems(0)
                    ->addActionLabel(__('Add slot'))
                    ->schema([
                        Select::make('schedule_id')
                            ->label(__('Time slot'))
                            ->required()
                            ->options(fn (): array => Schedule::query()->orderBy('date_start')->get()
                                ->mapWithKeys(fn (Schedule $slot) => [$slot->id => $slot->name.' · '.$slot->date_start->format('d/m H:i')])->all()),
                        Select::make('localization_id')
                            ->label(__('Room'))
                            ->required()
                            ->options(fn (RelationManager $livewire): array => Localization::query()
                                ->where('event_id', $livewire->getOwnerRecord()->getKey())
                                ->get()
                                ->mapWithKeys(fn (Localization $room) => [$room->id => (string) $room->name])->all()),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->label(__('Title'))->searchable()->wrap(),
                TextColumn::make('line.title')->label(__('Track'))->badge(),
                TextColumn::make('speakers.name')->label(__('Speakers'))->badge()->color('gray')->toggleable(),
                TextColumn::make('schedules_count')->label(__('Slots'))->counts('schedules'),
            ])
            ->filters([
                SelectFilter::make('line')->label(__('Track'))->relationship('line', 'title')->getOptionLabelFromRecordUsing(fn ($record) => $record->title),
            ])
            ->headerActions([
                LocaleSwitcher::make(),
                CreateAction::make()->modalWidth('4xl'),
            ])
            ->recordActions([
                EditAction::make()->modalWidth('4xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
