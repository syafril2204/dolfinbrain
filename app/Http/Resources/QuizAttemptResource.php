<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizAttemptResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $questions = $this->whenLoaded('quizPackage', fn() => $this->quizPackage->questions);
        $userAnswersMap = $this->whenLoaded('details', fn() => $this->details->pluck('answer_id', 'question_id'));

        $correctCount = 0;
        $incorrectCount = 0;
        $unansweredCount = 0;

        foreach ($questions as $question) {
            $userAnswerId = $userAnswersMap[$question->id] ?? null;
            if ($userAnswerId === null) {
                $unansweredCount++;
            } else {
                $correctAnswer = $question->answers->where('is_correct', true)->first();
                if ($correctAnswer && $userAnswerId == $correctAnswer->id) {
                    $correctCount++;
                } else {
                    $incorrectCount++;
                }
            }
        }

        return [
            'attempt_id' => $this->id,
            'quiz_package' => [
                'id' => $this->quizPackage->id,
                'title' => $this->quizPackage->title,
            ],
            'summary' => [
                'score' => round($this->score, 2),
                'correct_count' => $correctCount,
                'incorrect_count' => $incorrectCount,
                'unanswered_count' => $unansweredCount,
                'total_questions' => $questions->count(),
            ],
            'questions' => $questions->map(function ($question) use ($userAnswersMap) {
                return new QuestionResultResource($question, $userAnswersMap[$question->id] ?? null);
            }),
        ];
    }
}
