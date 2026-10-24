<?php

namespace App\Models;

use App\Pages\SectionData;
use App\Pages\Template;
use App\Pages\Templates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * A public page. Its template (App\Pages\Templates) declares the sections and
 * fields the editor fills in; the values are stored in `sections` as
 * {section: {field: value}} where translatable values are {locale: text}.
 */
class Page extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'template', 'title', 'sections', 'seo', 'published'];

    public array $translatable = ['title', 'seo'];

    protected function casts(): array
    {
        return [
            'sections' => 'array',
            'published' => 'boolean',
        ];
    }

    public function template(): Template
    {
        return Templates::find($this->template);
    }

    public function section(string $key): SectionData
    {
        return new SectionData($this->sections[$key] ?? []);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    /**
     * Cached lookup used by the public site; cleared on save. Only the raw
     * attributes are cached: the cache store refuses to unserialize models.
     */
    public static function findBySlug(string $slug): ?self
    {
        $attributes = cache()->rememberForever("page:{$slug}", fn () => static::query()->slug($slug)->first()?->getAttributes() ?: []);

        return $attributes === [] ? null : static::query()->hydrate([$attributes])->first();
    }

    protected static function booted(): void
    {
        $forget = fn (self $page) => cache()->forget("page:{$page->slug}") && cache()->forget("page:{$page->getOriginal('slug')}");

        static::saved($forget);
        static::deleted($forget);
    }
}
