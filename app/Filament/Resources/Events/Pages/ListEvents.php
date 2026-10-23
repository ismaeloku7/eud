<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use App\Filament\Support\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;
}
