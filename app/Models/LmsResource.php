<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LmsResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'lms_space_id',
        'title',
        'file_path',
        'file_size',
        'file_type',
        'type',
    ];

    public function lmsSpace(): BelongsTo
    {
        return $this->belongsTo(LmsSpace::class);
    }
}
