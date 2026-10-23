<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Workshop extends Model
{
    use HasTranslations;

    protected $fillable = ['event_id', 'line_id', 'title', 'description', 'collection', 'video_url'];

    public array $translatable = ['title', 'description'];

    protected function casts(): array
    {
        return ['collection' => 'boolean'];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function line(): BelongsTo
    {
        return $this->belongsTo(Line::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'workshops_speakers');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(WorkshopSchedule::class);
    }
}
