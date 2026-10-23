<?php

namespace App\Filament\Resources\TypeFiles\Pages;

use App\Filament\Resources\TypeFiles\TypeFileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTypeFiles extends ManageRecords
{
    protected static string $resource = TypeFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
