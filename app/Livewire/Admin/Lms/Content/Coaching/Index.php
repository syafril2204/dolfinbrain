<?php

namespace App\Livewire\Admin\Lms\Content\Coaching;

use App\Models\LmsCoaching;
use App\Models\LmsSpace;
use Livewire\Component;

class Index extends Component
{
    public LmsSpace $lms_space;

    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }

    public function delete(LmsCoaching $coaching)
    {
        $coaching->delete();
        session()->flash('message', 'Jadwal coaching berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.lms.content.coaching.index', [
            'coachings' => $this->lms_space->coachings()->latest()->get()
        ])->layout('components.layouts.app');
    }
}
