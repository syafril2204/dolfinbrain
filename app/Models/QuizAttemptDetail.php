<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttemptDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'answer_id',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];
}
