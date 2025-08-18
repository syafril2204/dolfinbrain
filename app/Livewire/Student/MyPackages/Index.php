<?php

namespace App\Livewire\Student\MyPackages;

use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    /**
     * Mengubah paket aktif pengguna.
     */
    public function setActivePackage(Position $position)
    {
        $user = Auth::user();
        $user->update(['position_id' => $position->id]);
        session()->flash('message', 'Paket untuk ' . $position->name . ' telah diaktifkan!');
        return $this->redirect(route('students.my-packages.index'), navigate: true);
    }

    /**
     * Merender komponen.
     */
    public function render()
    {
        $user = Auth::user();

        // 1. Ambil semua paket posisi yang pernah dibeli (ini PASTI punya data pivot)
        $purchasedPositions = $user->purchasedPositions()->with('formation')->get();

        // 2. Ambil posisi aktif pengguna saat ini (ini MUNGKIN paket gratis dan TIDAK punya pivot)
        $activePosition = $user->position()->with('formation')->first();

        // 3. Gabungkan keduanya untuk mendapatkan daftar semua posisi yang relevan
        $allRelevantPositions = $purchasedPositions->push($activePosition)->filter()->unique('id');

        // 4. Kelompokkan semua posisi relevan tersebut berdasarkan formasi
        $groupedByFormation = $allRelevantPositions->groupBy('formation.id');

        return view('livewire.student.my-packages.index', [
            'groupedByFormation' => $groupedByFormation,
            // 5. Kirim juga daftar MURNI paket yg dibeli untuk mempermudah pengecekan
            'purchasedPositions' => $purchasedPositions
        ])->layout('components.layouts.app');
    }
}
