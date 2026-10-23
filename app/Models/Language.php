<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Language extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'code'];

    public array $translatable = ['name'];

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
