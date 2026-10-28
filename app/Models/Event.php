<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Event extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'slug', 'title', 'subtitle', 'description', 'type', 'slogan', 'quote', 'tags',
        'date_start', 'date_end', 'publish',
        'photo_portada', 'facebook_banner', 'image_about', 'url_youtube', 'url_video', 'playlist_video', 'url_gallery',
        'location', 'lat', 'long', 'location_url', 'location_description', 'location_recursive', 'location_images',
        'registration', 'registration_eud', 'registration_non_eud', 'registration_recursive',
        'about_tab', 'speaker_tab', 'speaker_title', 'workshop_tab', 'workshop_title', 'workshop_description',
        'location_tab', 'location_title', 'program_tab', 'program_title', 'program_subtitle', 'program_description',
        'program_image', 'program_download', 'gallery_tab', 'gallery_title', 'main_session_tab', 'main_session_title',
        'registration_tab', 'registration_title',
    ];

    public array $translatable = [
        'slug', 'title', 'subtitle', 'description', 'type', 'slogan', 'quote', 'tags',
        'location', 'location_description', 'registration_eud', 'registration_non_eud',
        'about_tab', 'speaker_tab', 'speaker_title', 'workshop_tab', 'workshop_title', 'workshop_description',
        'location_tab', 'location_title', 'program_tab', 'program_title', 'program_subtitle', 'program_description',
        'gallery_tab', 'gallery_title', 'main_session_tab', 'main_session_title', 'registration_tab', 'registration_title',
    ];

    protected function casts(): array
    {
        return [
            'date_start' => 'datetime',
            'date_end' => 'datetime',
            'publish' => 'boolean',
            'registration' => 'boolean',
            'location_recursive' => 'array',
            'location_images' => 'array',
            'registration_recursive' => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('downloads');
        $this->addMediaCollection('gallery');
    }

    public function workshops(): HasMany
    {
        return $this->hasMany(Workshop::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class)->orderBy('date_start');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class)->orderBy('date_start');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(Line::class);
    }

    public function localizations(): HasMany
    {
        return $this->hasMany(Localization::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class)->orderBy('position');
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'events_speakers');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('publish', true);
    }

    /** Find by the slug of the current locale, falling back to English. */
    public function scopeWhereSlug(Builder $query, string $slug, ?string $locale = null): Builder
    {
        $locale ??= app()->getLocale();

        return $query->where(fn (Builder $q) => $q
            ->where("slug->{$locale}", $slug)
            ->orWhere(fn (Builder $q2) => $q2->whereNull("slug->{$locale}")->where('slug->en', $slug)));
    }
}
