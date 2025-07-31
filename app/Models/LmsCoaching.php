<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LmsCoaching extends Model
{
    use HasFactory;

    protected $fillable = [
        'lms_space_id',
        'title',
        'trainer_name',
        'meeting_url',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function lmsSpace(): BelongsTo
    {
        return $this->belongsTo(LmsSpace::class);
    }
}
