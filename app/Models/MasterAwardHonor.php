<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class MasterAwardHonor extends Model
{
    use HasTranslations;

    protected $fillable = ['name'];

    public array $translatable = ['name'];

    public function honors(): HasMany
    {
        return $this->hasMany(Honor::class, 'master_award_id');
    }
}
