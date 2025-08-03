<?php

namespace App\Livewire\Student\Lms;

use App\Models\LmsSpace;
use Livewire\Component;

class Show extends Component
{
    public LmsSpace $lms_space;

    public function mount(LmsSpace $lms_space)
    {
        if (!auth()->user()->hasLmsAccess() || !auth()->user()->position->lmsSpaces->contains($lms_space)) {
            return abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $this->lms_space = $lms_space;
    }

    public function render()
    {
        return view('livewire.student.lms.show')
            ->layout('components.layouts.app');
    }
}
