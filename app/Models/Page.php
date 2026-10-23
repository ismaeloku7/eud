<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * A public page made of ordered blocks. `blocks` is the Filament Builder
 * payload: [{type: 'hero', data: {...}}, ...]. Block data is stored per
 * locale through the translatable cast so each field has its EN/ES value.
 */
class Page extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'title', 'blocks', 'seo', 'published'];

    public array $translatable = ['title', 'blocks', 'seo'];

    protected function casts(): array
    {
        return ['published' => 'boolean'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
