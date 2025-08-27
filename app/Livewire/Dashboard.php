<?php

namespace App\Livewire;

use App\Models\Banner;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{


    public function mount()
    {
        if (!Auth::user()->hasRole('admin') && auth()->user()->position_id == null) {
            $this->redirect(route('students.profile.update'), navigate: true);
        }
    }


    public function render()
    {
        if (Auth::user()->hasRole('admin')) {
            return view('livewire.admin-dashboard-wrapper');
        } else {
            $banners = Banner::all();
            return view('livewire.dashboard', compact('banners'));
        }
    }
}
