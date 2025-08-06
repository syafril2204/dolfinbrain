<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizAttemptResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Ambil detail jawaban pengguna dari relasi
        $userAnswers = $this->whenLoaded('details', function () {
            return $this->details->pluck('answer_id', 'question_id');
        });

        return [
            'attempt_id' => $this->id,
            'quiz_package_title' => $this->quizPackage->title,
            'status' => $this->status,
            'score' => $this->score,
            'finished_at' => $this->finished_at ? $this->finished_at->translatedFormat('j F Y, H:i') : null,
            'questions' => $this->whenLoaded('quizPackage.questions', function () use ($userAnswers) {
                return $this->quizPackage->questions->map(function ($question) use ($userAnswers) {
                    return [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
                        'explanation' => $question->explanation,
                        'user_answer_id' => $userAnswers[$question->id] ?? null,
                        'answers' => AnswerResultResource::collection($question->answers),
                    ];
                });
            }),
        ];
    }
}
