<?php

namespace App\Livewire\Student\Quiz;

use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PackageIndex extends Component
{
    public function render()
    {
        $packages = collect();
        $latestPackageId = null;
        $user = Auth::user();

        if ($user && $user->position_id) {
            $position = Position::with('quizPackages')->find($user->position_id);
            if ($position) {
                $packages = $position->quizPackages()->where('is_active', true)->latest()->get();

                $latestPackageId = $packages->first()->id ?? null;
            }
        }

        return view('livewire.student.quiz.package-index', [
            'packages' => $packages,
            'latestPackageId' => $latestPackageId,
        ])->layout('components.layouts.app');
    }
}
