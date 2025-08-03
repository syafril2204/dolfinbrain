<?php

namespace App\Livewire\Student\Lms\Content;

use App\Models\LmsSpace;
use Livewire\Component;

class Coaching extends Component
{
    public LmsSpace $lms_space;
    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }
    public function render()
    {
        return view('livewire.student.lms.content.coaching', [
            'coachings' => $this->lms_space->coachings()->orderBy('start_at')->get()
        ])->layout('components.layouts.app');
    }
}
