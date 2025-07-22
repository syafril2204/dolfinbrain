<?php

namespace App\Livewire\Admin\Quiz\Questions;

use App\Models\Question;
use App\Models\QuizPackage;
use Livewire\Component;

class Index extends Component
{
    public QuizPackage $quiz_package;

    public function mount(QuizPackage $quiz_package)
    {
        $this->quiz_package = $quiz_package;
    }

    public function render()
    {
        $questions = $this->quiz_package->questions()->with('answers')->latest()->get();

        return view('livewire.admin.quiz.questions.index', [
            'questions' => $questions
        ])->layout('components.layouts.app');
    }

    public function delete(Question $question)
    {
        $question->delete();
        session()->flash('message', 'Soal berhasil dihapus.');
    }
}
