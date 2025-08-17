<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_description', 'slug', 'image'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($formation) {
            $formation->slug = Str::slug($formation->name);
        });
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
}
