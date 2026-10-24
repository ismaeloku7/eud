<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/** A workshop track ("line") inside an event, identified by a colour. */
class Line extends Model
{
    use HasTranslations;

    protected $fillable = ['event_id', 'title', 'description', 'color'];

    public array $translatable = ['title', 'description'];

    public function workshops(): HasMany
    {
        return $this->hasMany(Workshop::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
