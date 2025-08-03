<?php

namespace App\Livewire\Student\Lms\Content;

use App\Models\LmsSpace;
use Livewire\Component;

class Audio extends Component
{
    public LmsSpace $lms_space;
    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }
    public function render()
    {
        return view('livewire.student.lms.content.audio', [
            'audios' => $this->lms_space->resources()->where('type', 'audio_recording')->get()
        ])->layout('components.layouts.app');
    }
}
