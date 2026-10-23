<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'image', 'country_id'];

    public array $translatable = ['name'];

    /** Parent country, used for unions that group several countries. */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Country::class, 'country_id');
    }

    public function directors(): HasMany
    {
        return $this->hasMany(Director::class);
    }

    public function office(): HasOne
    {
        return $this->hasOne(OfficeGeneral::class);
    }
}
