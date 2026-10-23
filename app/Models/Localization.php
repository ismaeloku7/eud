<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/** A room / venue inside an event. */
class Localization extends Model
{
    use HasTranslations;

    protected $fillable = ['event_id', 'name', 'capacity'];

    public array $translatable = ['name', 'capacity'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function workshopSchedules(): HasMany
    {
        return $this->hasMany(WorkshopSchedule::class);
    }
}
