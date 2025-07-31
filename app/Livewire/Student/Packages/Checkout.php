<?php

namespace App\Livewire\Student\Packages;

use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public $packageType; // 'mandiri' atau 'bimbingan'
    public ?Position $position;
    public $packageName;
    public $price;
    public $transactionId;
    public $agree = false;

    public function mount($package_type)
    {
        if (!in_array($package_type, ['mandiri', 'bimbingan'])) {
            return abort(404);
        }

        $this->packageType = $package_type;
        $user = Auth::user();

        if (!$user->position_id) {
            session()->flash('error', 'Silakan pilih jabatan terlebih dahulu.');
            return $this->redirect(route('student.packages.index'));
        }

        $this->position = Position::with('formation')->find($user->position_id);
        $this->packageName = ($this->packageType === 'mandiri') ? 'Paket Mandiri' : 'Paket Bimbingan';
        $this->price = ($this->packageType === 'mandiri') ? $this->position->price_mandiri : $this->position->price_bimbingan;

        $this->transactionId = 'TRX' . strtoupper(Str::random(10));
    }

    public function processPayment()
    {
        $this->validate(['agree' => 'accepted']);
        session()->flash('message', 'Fitur pembayaran akan segera hadir!');
    }

    public function render()
    {
        return view('livewire.student.packages.checkout')
            ->layout('components.layouts.app');
    }
}
