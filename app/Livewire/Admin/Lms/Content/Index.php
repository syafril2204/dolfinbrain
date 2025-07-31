<?php

namespace App\Livewire\Admin\Lms\Content;

use App\Models\LmsSpace;
use Livewire\Component;

class Index extends Component
{
    public LmsSpace $lms_space;

    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }

    public function render()
    {
        return view('livewire.admin.lms.content.index')
            ->layout('components.layouts.app');
    }
}
