<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Where and when a workshop takes place (a workshop can repeat). */
class WorkshopSchedule extends Model
{
    protected $table = 'workshops_schedules';

    protected $fillable = ['workshop_id', 'schedule_id', 'localization_id'];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function localization(): BelongsTo
    {
        return $this->belongsTo(Localization::class);
    }
}
