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

    public function render()
    {
        $user = Auth::user();

        // Ambil semua posisi yang pernah dibeli oleh pengguna
        $purchasedPositions = $user->purchasedPositions()->with('formation')->get();

        // Variabel untuk menampung paket gratis jika tidak ada paket yang dibeli
        $freePosition = null;

        // Jika tidak ada paket yang dibeli TAPI pengguna punya posisi dari registrasi
        if ($purchasedPositions->isEmpty() && $user->position) {
            $freePosition = $user->position()->with('formation')->first();
        }

        return view('livewire.student.my-packages.index', [
            'purchasedPositions' => $purchasedPositions,
            'freePosition' => $freePosition, // Kirim data paket gratis ke view
        ])->layout('components.layouts.app');
    }
}
