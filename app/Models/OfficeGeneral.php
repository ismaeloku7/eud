<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/** Contact details of a union / conference office, one per country. */
class OfficeGeneral extends Model
{
    use HasTranslations;

    protected $fillable = [
        'country_id', 'title', 'description', 'address', 'phone', 'email',
        'website', 'website_2', 'facebook', 'instagram', 'linkedin', 'twitter', 'youtube',
    ];

    public array $translatable = ['title', 'description'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
