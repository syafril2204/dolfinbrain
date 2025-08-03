<?php

namespace App\Livewire\Student\Lms\Content;

use App\Models\LmsSpace;
use Livewire\Component;

class Quizzes extends Component
{
    public LmsSpace $lms_space;
    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }
    public function render()
    {
        return view('livewire.student.lms.content.quizzes', [
            'quizPackages' => $this->lms_space->quizPackages
        ])->layout('components.layouts.app');
    }
}
