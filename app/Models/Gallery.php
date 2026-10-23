<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = ['event_id', 'image', 'position'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
