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
            return view('livewire.dashboard');
        }
    }
}
