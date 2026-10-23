<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/** A time slot workshops can be scheduled into. */
class Schedule extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'date_start', 'date_end'];

    public array $translatable = ['name'];

    protected function casts(): array
    {
        return ['date_start' => 'datetime', 'date_end' => 'datetime'];
    }

    public function workshopSchedules(): HasMany
    {
        return $this->hasMany(WorkshopSchedule::class);
    }
}
