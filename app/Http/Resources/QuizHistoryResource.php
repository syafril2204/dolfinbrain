<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attempt_id' => $this->id,
            'quiz_package_title' => $this->whenLoaded('quizPackage', $this->quizPackage->title),
            'score' => round($this->score),
            'finished_at' => $this->finished_at->translatedFormat('j F Y, H:i'),
            'result_url' => route('api.quiz.result', ['attempt' => $this->id]),
        ];
    }
}
