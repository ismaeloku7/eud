<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Speaker extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'description', 'type', 'photo'];

    public array $translatable = ['name', 'description', 'type'];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'events_speakers');
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'programs_speakers');
    }

    public function workshops(): BelongsToMany
    {
        return $this->belongsToMany(Workshop::class, 'workshops_speakers');
    }
}
