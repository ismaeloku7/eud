<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeFile extends Model
{
    protected $fillable = ['name'];

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
