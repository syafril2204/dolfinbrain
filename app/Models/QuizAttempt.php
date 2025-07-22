<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_package_id',
        'score',
        'status',
        'finished_at',
    ];

    protected $casts = [
        'finished_at' => 'datetime',
    ];

    public function attemptDetails()
    {
        return $this->hasMany(QuizAttemptDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizPackage()
    {
        return $this->belongsTo(QuizPackage::class);
    }
}
