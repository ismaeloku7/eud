<?php

namespace App\Filament\Support\Forms;

use Filament\Forms\Components\FileUpload;

/** Upload fields with the project's conventions: public disk, one folder per content type. */
class Uploads
{
    public static function image(string $name, string $directory, ?string $label = null): FileUpload
    {
        return FileUpload::make($name)
            ->label($label ?? __('Image'))
            ->image()
            ->imageEditor()
            ->disk('public')
            ->directory($directory)
            ->visibility('public')
            ->maxSize(5 * 1024)
            ->openable()
            ->downloadable();
    }

    public static function document(string $name, string $directory, ?string $label = null): FileUpload
    {
        return FileUpload::make($name)
            ->label($label ?? __('File'))
            ->disk('public')
            ->directory($directory)
            ->visibility('public')
            ->maxSize(100 * 1024)
            ->openable()
            ->downloadable()
            ->preserveFilenames();
    }
}
