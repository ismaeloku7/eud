<?php

namespace App\Filament\Support\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords as BaseListRecords;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

abstract class ListRecords extends BaseListRecords
{
    use Translatable;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
