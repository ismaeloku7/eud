<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class PdfHonor extends Model
{
    use HasTranslations;

    protected $fillable = ['honor_id', 'language_id', 'name', 'file', 'size'];

    public array $translatable = ['name'];

    public function honor(): BelongsTo
    {
        return $this->belongsTo(Honor::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
