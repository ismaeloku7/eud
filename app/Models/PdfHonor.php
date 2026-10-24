<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class PdfHonor extends Model
{
    use HasTranslations;

    protected $fillable = ['honor_id', 'language_id', 'name', 'file', 'size'];

    public array $translatable = ['name'];

    /** Keep `size` in sync with the uploaded file so lists can show it without touching the disk. */
    protected static function booted(): void
    {
        static::saving(function (self $model): void {
            if ($model->isDirty('file') && $model->file && Storage::disk('public')->exists($model->file)) {
                $model->size = Storage::disk('public')->size($model->file);
            }
        });
    }

    public function honor(): BelongsTo
    {
        return $this->belongsTo(Honor::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
