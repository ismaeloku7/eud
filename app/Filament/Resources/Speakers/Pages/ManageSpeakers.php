<?php

namespace App\Filament\Resources\Speakers\Pages;

use App\Filament\Resources\Speakers\SpeakerResource;
use App\Filament\Support\Pages\ManageRecords;

class ManageSpeakers extends ManageRecords
{
    protected static string $resource = SpeakerResource::class;
}
