<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_package_id',
        'question_text',
        'explanation',
        'points',
        'type'
    ];

    public function quizPackage(): BelongsTo
    {
        return $this->belongsTo(QuizPackage::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
