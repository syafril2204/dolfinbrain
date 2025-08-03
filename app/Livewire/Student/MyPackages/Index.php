<?php

namespace App\Livewire\Student\MyPackages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $activePosition;
    public $activePackageType;
    public $otherPurchasedPositions;

    public function mount()
    {
        $this->loadPackages();
    }

    public function loadPackages()
    {
        $user = Auth::user();

        // 1. Ambil posisi yang sedang aktif
        $this->activePosition = $user->position()->with('formation')->first();

        // 2. Cek jenis paket untuk posisi yang aktif
        $activePurchase = $user->purchasedPositions()->where('position_id', $user->position_id)->first();
        $this->activePackageType = $activePurchase ? $activePurchase->pivot->package_type : 'gratis';

        // 3. Ambil semua paket yang dibeli, KECUALI yang sedang aktif
        $this->otherPurchasedPositions = $user->purchasedPositions()
            ->where('position_id', '!=', $user->position_id)
            ->with('formation')
            ->get();
    }

    // Fungsi untuk mengganti paket aktif
    public function setActivePackage($positionId)
    {
        $user = Auth::user();
        $user->position_id = $positionId;
        $user->save();

        session()->flash('message', 'Paket berhasil diaktifkan.');

        $this->loadPackages();
    }

    public function render()
    {
        return view('livewire.student.my-packages.index')
            ->layout('components.layouts.app');
    }
}
