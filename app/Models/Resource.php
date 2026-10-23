<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

/**
 * A downloadable resource (manual, guide, media pack...). When `collection`
 * is true the resource is a container for other resources instead of files.
 */
class Resource extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'subtitle', 'intro', 'description', 'legend', 'pages',
        'slug', 'author', 'image', 'collection', 'featured', 'quantity',
    ];

    public array $translatable = ['title', 'subtitle', 'intro', 'description', 'legend', 'pages'];

    protected function casts(): array
    {
        return [
            'collection' => 'boolean',
            'featured' => 'boolean',
            'quantity' => 'integer',
        ];
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'model');
    }

    public function ministries(): BelongsToMany
    {
        return $this->belongsToMany(Ministry::class, 'ministry_resources');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CategoryResource::class, 'category_resource_resources', 'resource_id', 'category_id');
    }

    /** Resources contained in this collection. */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Resource::class, 'project_resources', 'project_id', 'resource_id')
            ->withPivot('position')
            ->orderByPivot('position');
    }

    /** Collections this resource belongs to. */
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Resource::class, 'project_resources', 'resource_id', 'project_id');
    }

    public function related(): BelongsToMany
    {
        return $this->belongsToMany(Resource::class, 'related_resources', 'resource_id', 'related_id');
    }
}
