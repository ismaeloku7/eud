<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Director extends Model
{
    use HasTranslations;

    protected $fillable = [
        'country_id', 'ministry_id', 'type_director_id',
        'name', 'charge', 'description', 'photo', 'email', 'address',
        'website', 'website_2', 'facebook', 'instagram', 'linkedin', 'twitter', 'youtube',
    ];

    public array $translatable = ['charge', 'description'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function ministry(): BelongsTo
    {
        return $this->belongsTo(Ministry::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeDirector::class, 'type_director_id');
    }
}
