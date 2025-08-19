<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LmsVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'lms_space_id',
        'title',
        'youtube_url',
        'duration',
        'order',
    ];

    public function lmsSpace(): BelongsTo
    {
        return $this->belongsTo(LmsSpace::class);
    }
    public function getYoutubeThumbnailAttribute()
    {
        if (!$this->youtube_url) {
            return asset('assets/images/placeholder-video.jpg');
        }

        // Ambil video ID dari link YouTube
        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->youtube_url, $matches);

        return isset($matches[1])
            ? "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg"
            : asset('assets/images/placeholder-video.jpg');
    }
}
