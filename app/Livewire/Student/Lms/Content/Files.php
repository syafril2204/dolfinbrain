<?php

namespace App\Livewire\Student\Lms\Content;

use App\Models\LmsSpace;
use Livewire\Component;

class Files extends Component
{
    public LmsSpace $lms_space;
    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }
    public function render()
    {
        return view('livewire.student.lms.content.files', [
            'files' => $this->lms_space->resources()->where('type', 'recap_file')->get()
        ])->layout('components.layouts.app');
    }
}
