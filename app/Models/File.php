<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

class File extends Model
{
    protected $fillable = ['model_type', 'model_id', 'language_id', 'type_file_id', 'file', 'url', 'size'];

    protected function casts(): array
    {
        return ['size' => 'integer'];
    }

    /** Keep `size` in sync with the uploaded file so lists can show it without touching the disk. */
    protected static function booted(): void
    {
        static::saving(function (self $model): void {
            if ($model->isDirty('file') && $model->file && Storage::disk('public')->exists($model->file)) {
                $model->size = Storage::disk('public')->size($model->file);
            }
        });
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeFile::class, 'type_file_id');
    }

    public function humanSize(): string
    {
        return $this->size ? Number::fileSize($this->size) : '';
    }
}
