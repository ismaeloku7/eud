<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Honor extends Model
{
    use HasTranslations;

    protected $fillable = [
        'ministry_id', 'category_id', 'class_id', 'level_id', 'master_award_id',
        'name', 'description', 'requirements', 'image', 'image_secondary', 'url',
    ];

    public array $translatable = ['name', 'description', 'requirements'];

    public function ministry(): BelongsTo
    {
        return $this->belongsTo(Ministry::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryHonor::class, 'category_id');
    }

    public function classHonor(): BelongsTo
    {
        return $this->belongsTo(ClassHonor::class, 'class_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelHonor::class, 'level_id');
    }

    public function masterAward(): BelongsTo
    {
        return $this->belongsTo(MasterAwardHonor::class, 'master_award_id');
    }

    public function pdfs(): HasMany
    {
        return $this->hasMany(PdfHonor::class);
    }
}
