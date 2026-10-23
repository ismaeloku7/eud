<?php

namespace App\Filament\Resources\ResourceCategories\Pages;

use App\Filament\Resources\ResourceCategories\ResourceCategoryResource;
use App\Filament\Support\Pages\ManageRecords;

class ManageResourceCategories extends ManageRecords
{
    protected static string $resource = ResourceCategoryResource::class;
}
