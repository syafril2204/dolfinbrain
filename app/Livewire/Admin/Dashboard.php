<?php

namespace App\Livewire\Admin;

use App\Models\Formation;
use App\Models\LmsSpace;
use App\Models\Material;
use App\Models\QuizPackage;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalStudents;
    public $totalFormations;
    public $totalMaterials;
    public $totalQuizPackages;
    public $totalLmsSpaces;
    public $totalPaidTransactions;
    public $recentTransactions;

    public function mount()
    {
        $this->totalStudents = User::role('student')->count();
        $this->totalFormations = Formation::count();
        $this->totalMaterials = Material::count();
        $this->totalQuizPackages = QuizPackage::count();
        $this->totalLmsSpaces = LmsSpace::count();
        $this->totalPaidTransactions = Transaction::where('status', 'paid')->sum('amount');

        $this->recentTransactions = Transaction::with('user', 'position')
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
