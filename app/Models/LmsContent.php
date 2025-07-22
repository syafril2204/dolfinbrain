<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'lms_meeting_id',
        'type',
        'title',
        'description',
        'content_url',
        'quiz_package_id',
        'is_active',
    ];

    public function lmsMeeting()
    {
        return $this->belongsTo(LmsMeeting::class);
    }

    public function quizPackage()
    {
        return $this->belongsTo(QuizPackage::class);
    }
}
