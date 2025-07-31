<?php

namespace App\Livewire\Admin\Quiz\Packages;

use App\Models\QuizPackage;
use Livewire\Component;

class Show extends Component
{
    public QuizPackage $quiz_package;

    public function mount(QuizPackage $quiz_package)
    {
        $this->quiz_package = $quiz_package->load('questions.answers', 'positions.formation');
    }

    public function render()
    {
        return view('livewire.admin.quiz.packages.show')
            ->layout('components.layouts.app');
    }
}
