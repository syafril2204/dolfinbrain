<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizPackageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'duration_in_minutes' => $this->duration_in_minutes,
            'total_questions' => $this->whenLoaded('questions', function () {
                return $this->questions->count();
            }),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        ];
    }
}
