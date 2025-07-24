<?php

namespace App\Livewire\Student\Quiz;

use App\Models\QuizAttempt;
use App\Models\QuizPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Url;

class Attempt extends Component
{
    public QuizPackage $quiz_package;
    public $questions;
    public $totalQuestions;

    #[Url(as: 'q', keep: true)]
    public $currentQuestionIndex = 0;

    public $userAnswers = [];
    public $timeRemaining;
    public ?QuizAttempt $attempt = null;

    public function mount(QuizPackage $quiz_package)
    {
        $this->quiz_package = $quiz_package;
        $this->questions = $quiz_package->questions()->with('answers')->get();
        $this->totalQuestions = $this->questions->count();
        $user = Auth::user();

        $progres_quiz = QuizAttempt::where('user_id', auth()->user()->id)
            ->where('quiz_package_id', $this->quiz_package->id)
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        if (!$progres_quiz) {
            $this->attempt = QuizAttempt::create([
                'user_id' => $user->id,
                'quiz_package_id' => $this->quiz_package->id,
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        } else {
            $this->attempt = $progres_quiz;
        }

        $startTime = $this->attempt->started_at;
        $endTime = $startTime->copy()->addMinutes(60);
        $this->timeRemaining = max(0, now()->diffInSeconds($endTime, false));

        $this->loadUserAnswers();
    }

    protected function loadUserAnswers()
    {
        $savedAnswers = $this->attempt->details()->get()->keyBy('question_id');
        foreach ($this->questions as $question) {
            $this->userAnswers[$question->id] = $savedAnswers[$question->id]->answer_id ?? null;
        }
    }

    public function selectAnswer($questionId, $answerId)
    {
        $this->userAnswers[$questionId] = $answerId;
        $this->attempt->details()->updateOrCreate(
            ['question_id' => $questionId],
            ['answer_id' => $answerId]
        );
    }

    public function goToQuestion($index)
    {
        if ($index >= 0 && $index < $this->totalQuestions) {
            $this->currentQuestionIndex = $index;
        }
    }

    public function submitQuiz()
    {
        if (!$this->attempt || $this->attempt->status !== 'in_progress') {
            return;
        }

        $score = 0;
        $correctAnswers = 0;

        DB::transaction(function () use (&$score, &$correctAnswers) {
            foreach ($this->questions as $question) {
                $selectedAnswerId = $this->userAnswers[$question->id] ?? null;
                $correctAnswer = $question->answers->where('is_correct', true)->first();
                $isCorrect = ($selectedAnswerId && $correctAnswer && $selectedAnswerId == $correctAnswer->id);

                if ($isCorrect) {
                    $correctAnswers++;
                }

                $this->attempt->details()
                    ->where('question_id', $question->id)
                    ->update(['is_correct' => $isCorrect]);
            }

            $score = ($this->totalQuestions > 0) ? ($correctAnswers / $this->totalQuestions) * 100 : 0;

            $this->attempt->update([
                'score' => $score,
                'status' => 'completed',
                'finished_at' => now(),
            ]);
        });

        session()->flash('message', 'Kuis telah selesai! Skor Anda: ' . round($score, 2));
        return $this->redirectRoute('students.soal.index');
    }

    public function render()
    {
        if ($this->currentQuestionIndex >= $this->totalQuestions || $this->currentQuestionIndex < 0) {
            $this->currentQuestionIndex = 0;
        }

        return view('livewire.student.quiz.attempt', [
            'currentQuestion' => $this->questions[$this->currentQuestionIndex]
        ])->layout('components.layouts.app');
    }
}
