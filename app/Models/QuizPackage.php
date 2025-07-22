<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'duration_in_minutes',
        'is_active',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_quiz_package');
    }
}
