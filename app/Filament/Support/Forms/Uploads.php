<?php

namespace App\Filament\Support\Forms;

use App\Support\Media;
use Filament\Forms\Components\FileUpload;

/**
 * Upload fields with the project's conventions: public disk, one folder per
 * content type, and support for files that are not on that disk (design
 * images of the previous site under /images, or uploads still downloading),
 * which must survive a save untouched.
 */
class Uploads
{
    public static function image(string $name, string $directory, ?string $label = null): FileUpload
    {
        return self::configure(FileUpload::make($name)->label($label ?? __('Image'))->image()->imageEditor(), $directory)
            ->maxSize(15 * 1024);
    }

    public static function document(string $name, string $directory, ?string $label = null): FileUpload
    {
        return self::configure(FileUpload::make($name)->label($label ?? __('File')), $directory)
            ->maxSize(100 * 1024)
            ->preserveFilenames();
    }

    private static function configure(FileUpload $upload, string $directory): FileUpload
    {
        return $upload
            ->disk('public')
            ->directory($directory)
            ->visibility('public')
            ->fetchFileInformation(false)
            ->getUploadedFileUsing(fn (string $file): array => [
                'name' => basename($file),
                'size' => 0,
                'type' => null,
                'url' => url(Media::url($file)),
            ])
            ->openable()
            ->getOpenableFileUrlUsing(fn (string $file): string => url(Media::url($file)))
            ->downloadable()
            ->getDownloadableFileUrlUsing(fn (string $file): string => url(Media::url($file)));
    }
}
