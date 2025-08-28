<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LmsSpaceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image_path ? Storage::url($this->image_path) : null,

            // Sertakan semua konten jika resource ini dimuat dengan relasinya
            'contents' => [
                'videos' => LMSVideoResource::collection($this->whenLoaded('videos')),
                'coachings' => LmsCoachingResource::collection($this->whenLoaded('coachings')),
                'files' => LmsResourceResource::collection($this->whenLoaded('resources')),
                'materials' => MaterialResource::collection($this->whenLoaded('materials')),
                'quizzes' => QuizPackageResource::collection($this->whenLoaded('quizPackages')),
            ]
        ];
    }
}
