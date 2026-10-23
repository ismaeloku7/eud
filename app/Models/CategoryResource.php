<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class CategoryResource extends Model
{
    use HasTranslations;

    protected $fillable = ['name'];

    public array $translatable = ['name'];

    public function resources(): BelongsToMany
    {
        return $this->belongsToMany(Resource::class, 'category_resource_resources', 'category_id', 'resource_id');
    }
}
