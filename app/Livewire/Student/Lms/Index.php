<?php

namespace App\Livewire\Student\Lms;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $user = Auth::user();
        $hasAccess = $user->hasLmsAccess();
        $lmsSpaces = collect();

        if ($hasAccess && $user->position) {
            $lmsSpaces = $user->position->lmsSpaces()->where('is_active', true)->get();
        }

        return view('livewire.student.lms.index', [
            'hasAccess' => $hasAccess,
            'lmsSpaces' => $lmsSpaces,
        ])->layout('components.layouts.app');
    }
}
