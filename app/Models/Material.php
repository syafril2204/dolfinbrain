<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'file_size',
        'file_type'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($material) {
            $material->slug = Str::slug($material->title);
        });
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class);
    }
}
