<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class QuestionResultResource extends JsonResource
{
    protected $userAnswerId;

    public function __construct($resource, $userAnswerId)
    {
        parent::__construct($resource);
        $this->userAnswerId = $userAnswerId;
    }

    public function toArray(Request $request): array
    {
        $correctAnswer = $this->whenLoaded('answers', fn() => $this->answers->where('is_correct', true)->first());
        $userAnswer = $this->whenLoaded('answers', fn() => $this->answers->find($this->userAnswerId));

        return [
            'id' => $this->id,
            'question_text' => $this->question_text,
            'image_url' => $this->image ? Storage::url($this->image) : null,
            'explanation' => $this->explanation,
            'is_correct' => $this->userAnswerId && $correctAnswer && $this->userAnswerId == $correctAnswer->id,
            'user_answer' => $userAnswer ? new AnswerResultResource($userAnswer) : null,
            'correct_answer' => $correctAnswer ? new AnswerResultResource($correctAnswer) : null,
            'all_options' => AnswerResultResource::collection($this->whenLoaded('answers')),
        ];
    }
}
