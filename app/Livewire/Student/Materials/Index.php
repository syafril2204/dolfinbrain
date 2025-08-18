<?php

namespace App\Livewire\Student\Materials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public string $searchTerm = '';

    public function render()
    {
        $user = Auth::user();
        $materials = collect(); // Default ke koleksi kosong

        $userHasPosition = !is_null($user->position_id);

        if ($userHasPosition) {
            // Ambil relasi materials dan filter berdasarkan searchTerm
            $query = $user->position->materials();

            if (!empty($this->searchTerm)) {
                $query->where('title', 'like', '%' . $this->searchTerm . '%');
            }

            $materials = $query->get();
        }

        return view('livewire.student.materials.index', [
            'userHasPosition' => $userHasPosition,
            'materials' => $materials,
        ])->layout('components.layouts.app');
    }
}
