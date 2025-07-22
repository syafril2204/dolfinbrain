<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_package_id',
        'question_text',
        'explanation',
        'points',
    ];

    public function quizPackage()
    {
        return $this->belongsTo(QuizPackage::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
