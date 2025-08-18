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

    protected $fillable = [
        'formation_id',
        'name',
        'slug',
        'price_mandiri',
        'price_bimbingan',
    ];

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

    public function purchasedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'position_user');
    }

    public function lmsSpaces(): BelongsToMany
    {
        return $this->belongsToMany(LmsSpace::class, 'lms_space_position');
    }

    public function calculateProgressForUser(User $user): int
    {
        $totalQuizzes = $this->quizPackages()->count();

        if ($totalQuizzes === 0) {
            return 0;
        }

        $quizPackageIds = $this->quizPackages()->pluck('id');

        $completedQuizzesCount = QuizAttempt::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereIn('quiz_package_id', $quizPackageIds)
            ->distinct()
            ->count('quiz_package_id');

        return round(($completedQuizzesCount / $totalQuizzes) * 100);
    }
}
