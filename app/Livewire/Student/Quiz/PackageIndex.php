<?php

namespace App\Livewire\Student\Quiz;

use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PackageIndex extends Component
{
    public $activeTab = 'soal';
    public $expandedPackageId = null;
    protected $queryString = ['activeTab'];

    public function switchTab($tabName)
    {
        $this->activeTab = $tabName;
        $this->expandedPackageId = null;
    }

    public function toggleHistory($packageId)
    {
        if ($this->expandedPackageId === $packageId) {
            $this->expandedPackageId = null;
        } else {
            $this->expandedPackageId = $packageId;
        }
    }

    public function render()
    {
        $user = Auth::user();
        $packages = collect();
        $latestPackageId = null;
        $historyPackages = collect();

        if ($user && $user->position_id) {
            $position = Position::find($user->position_id);
            if ($position) {
                $packages = $position->quizPackages()
                    ->where('is_active', true)
                    ->whereHas('questions')
                    ->latest()
                    ->get();

                $latestPackageId = $packages->first()->id ?? null;

                $historyPackages = $position->quizPackages()
                    ->whereHas('questions')
                    ->whereHas('attempts', function ($query) use ($user) {
                        $query->where('user_id', $user->id)->where('status', 'completed');
                    })
                    ->with(['attempts' => function ($query) use ($user) {
                        $query->where('user_id', $user->id)->where('status', 'completed')->orderBy('finished_at', 'desc');
                    }])
                    ->get();
            }
        }

        return view('livewire.student.quiz.package-index', [
            'packages' => $packages,
            'latestPackageId' => $latestPackageId,
            'historyPackages' => $historyPackages,
        ])->layout('components.layouts.app');
    }
}
