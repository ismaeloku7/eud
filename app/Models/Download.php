<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Download extends Model
{
    use HasTranslations;

    protected $fillable = ['event_id', 'name', 'document', 'language'];

    public array $translatable = ['name'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
