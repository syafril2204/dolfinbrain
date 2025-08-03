<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        if (Auth::user()->hasRole('admin')) {
            return view('livewire.admin-dashboard-wrapper');
        } else {
            if (auth()->user()->position_id == null) {
                return redirect()->route('students.profile.update');
            }
            return view('livewire.dashboard');
        }
    }
}
