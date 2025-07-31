<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LmsSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_path',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($space) {
            $space->slug = Str::slug($space->title);
        });
    }

    /**
     * Relasi ke sesi coaching (Satu LMS Space punya banyak sesi coaching)
     */
    public function coachings(): HasMany
    {
        return $this->hasMany(LmsCoaching::class);
    }

    /**
     * Relasi ke video rekaman (Satu LMS Space punya banyak video)
     */
    public function videos(): HasMany
    {
        return $this->hasMany(LmsVideo::class);
    }

    /**
     * Relasi ke file resources (Satu LMS Space punya banyak resource)
     */
    public function resources(): HasMany
    {
        return $this->hasMany(LmsResource::class);
    }

    /**
     * Relasi ke Position (Banyak LMS Space bisa untuk banyak Position)
     */
    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'lms_space_position');
    }

    /**
     * Relasi ke Material (Banyak LMS Space bisa punya banyak Material)
     */
    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'lms_space_material');
    }

    /**
     * Relasi ke QuizPackage (Banyak LMS Space bisa punya banyak Paket Kuis)
     */
    public function quizPackages(): BelongsToMany
    {
        return $this->belongsToMany(QuizPackage::class, 'lms_space_quiz_package');
    }
}
