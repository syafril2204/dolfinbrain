<?php

namespace App\Livewire\Student\Lms\Content;

use App\Models\LmsSpace;
use Livewire\Component;

class Materials extends Component
{
    public LmsSpace $lms_space;
    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }
    public function render()
    {
        return view('livewire.student.lms.content.materials', [
            'materials' => $this->lms_space->materials
        ])->layout('components.layouts.app');
    }
}
