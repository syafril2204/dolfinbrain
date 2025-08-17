<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LmsCoachingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'trainer_name' => $this->trainer_name,
            'meeting_url' => $this->meeting_url,
            'start_at' => $this->start_at->translatedFormat('l, d F Y - H:i'),
            'end_at' => $this->end_at->translatedFormat('l, d F Y - H:i'),
        ];
    }
}
