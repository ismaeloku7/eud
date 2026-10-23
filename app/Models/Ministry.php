<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Ministry extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'counter', 'position'];

    public array $translatable = ['name'];

    public function resources(): BelongsToMany
    {
        return $this->belongsToMany(Resource::class, 'ministry_resources');
    }

    public function directors(): HasMany
    {
        return $this->hasMany(Director::class);
    }

    public function honors(): HasMany
    {
        return $this->hasMany(Honor::class);
    }
}
