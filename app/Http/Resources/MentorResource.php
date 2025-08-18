<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MentorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'education' => $this->education,
            'motto' => $this->motto,
            'description' => $this->description,
            'photo_url' => $this->photo ? Storage::url($this->photo) : asset('dist/images/profile/user-1.jpg'),
            'position' => [
                'name' => $this->whenLoaded('position', $this->position->name),
                'formation' => $this->whenLoaded('position', function () {
                    return $this->position->formation->name;
                }),
            ],
        ];
    }
}
