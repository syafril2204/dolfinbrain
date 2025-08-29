<?php

namespace App\Livewire\Student\Quiz;

use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Result extends Component
{
    public QuizAttempt $attempt;
    // public Question $showQuestions;
    public $score = 0;
    public $correctCount = 0;
    public $incorrectCount = 0;
    public $unansweredCount = 0;
    public $userAnswers = [];

    public function mount(QuizAttempt $quiz_attempt)
    {
        // Keamanan: Pastikan hanya pemilik attempt yang bisa melihat halaman ini
        // dan statusnya sudah 'completed'
        if ($quiz_attempt->user_id !== Auth::id() || $quiz_attempt->status !== 'completed') {
            abort(403, 'Akses Ditolak');
        }

        $this->attempt = $quiz_attempt->load('quizPackage.questions.answers', 'details');
        $this->userAnswers = $this->attempt->details->pluck('answer_id', 'question_id');
        $this->score = $this->attempt->score;

        $this->calculateStats();

        // dd($this->attempt->quizPackage->id);
    }

    /**
     * Menghitung statistik jawaban benar, salah, dan tidak dijawab.
     */
    public function calculateStats()
    {
        $questions = $this->attempt->quizPackage->questions;

        foreach ($questions as $question) {
            $userAnswerId = $this->userAnswers[$question->id] ?? null;

            if ($userAnswerId === null) {
                $this->unansweredCount++;
            } else {
                $correctAnswer = $question->answers->where('is_correct', true)->first();
                if ($correctAnswer && $userAnswerId == $correctAnswer->id) {
                    $this->correctCount++;
                } else {
                    $this->incorrectCount++;
                }
            }
        }
    }

    public function render()
    {
        $showQuestions = Question::where('quiz_package_id', $this->attempt->quizPackage->id)->paginate(1);
        return view('livewire.student.quiz.result', compact('showQuestions'))->layout('components.layouts.app');
    }
}
