<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/** An entry in the event programme (plenary, meal, main session...). */
class Program extends Model
{
    use HasTranslations;

    protected $fillable = ['event_id', 'title', 'description', 'date_start', 'date_end', 'color', 'main_session', 'sync_workshop'];

    public array $translatable = ['title', 'description'];

    protected function casts(): array
    {
        return [
            'date_start' => 'datetime',
            'date_end' => 'datetime',
            'main_session' => 'boolean',
            'sync_workshop' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'programs_speakers');
    }
}
