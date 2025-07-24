<?php

namespace App\Livewire\Student\Materials;

use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $searchTerm = '';

    public function render()
    {
        $materials = collect();
        $user = Auth::user();

        if ($user && $user->position_id) {
            $position = Position::with('materials')->find($user->position_id);

            if ($position) {
                $materials = $position->materials()
                    ->where('title', 'like', '%' . $this->searchTerm . '%')
                    ->get();
            }
        }

        return view('livewire.student.materials.index', [
            'materials' => $materials,
            'userHasPosition' => !is_null($user->position_id),
        ])->layout('components.layouts.app');
    }
}
