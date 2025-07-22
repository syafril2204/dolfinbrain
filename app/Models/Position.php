<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['formation_id', 'name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($position) {
            $position->slug = Str::slug($position->name);
        });
    }

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function quizPackages(): BelongsToMany
    {
        return $this->belongsToMany(QuizPackage::class);
    }
}
