<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class CategoryHonor extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'color', 'position'];

    public array $translatable = ['name'];

    public function honors(): HasMany
    {
        return $this->hasMany(Honor::class, 'category_id');
    }
}
