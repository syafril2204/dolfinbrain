<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'scheduled_at',
        'is_active',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'lms_meeting_position');
    }

    public function contents()
    {
        return $this->hasMany(LmsContent::class);
    }
}
