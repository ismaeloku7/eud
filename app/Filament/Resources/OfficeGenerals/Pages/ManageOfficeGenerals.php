<?php

namespace App\Filament\Resources\OfficeGenerals\Pages;

use App\Filament\Resources\OfficeGenerals\OfficeGeneralResource;
use App\Filament\Support\Pages\ManageRecords;
use Filament\Actions\CreateAction;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class ManageOfficeGenerals extends ManageRecords
{
    protected static string $resource = OfficeGeneralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make()->modalWidth('4xl'),
        ];
    }
}
