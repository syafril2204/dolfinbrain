<?php

namespace App\Livewire\Student\Profile;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Index extends Component
{
    // Mengontrol bagian mana yang aktif
    public $activeSection = 'main';

    // Properti untuk Ubah Profile
    public $name, $email, $phone_number, $domicile;

    // Properti untuk Ubah Password
    public $current_password, $password, $password_confirmation;

    // Properti untuk Ubah Formasi
    public $formations, $selectedFormation, $position_id;
    public $formationStep = 1;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->domicile = $user->domicile;
    }

    // Mengganti tampilan form
    public function switchSection($section)
    {
        $this->resetErrorBag();
        $this->activeSection = $section;

        // Muat data formasi jika section-nya dipilih
        if ($section === 'change_formation') {
            $this->formations = Formation::with('positions')->get();
            $this->formationStep = 1;
        }
    }

    // Logika untuk Ubah Profile
    public function updateProfile()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:15',
            'domicile' => 'nullable|string|max:255',
        ]);

        Auth::user()->update($validatedData);
        session()->flash('message', 'Profil berhasil diperbarui.');
        $this->switchSection('main');
    }

    // Logika untuk Ubah Password
    public function updatePassword()
    {
        $validatedData = $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validatedData['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');
        session()->flash('message', 'Password berhasil diubah.');
        $this->switchSection('main');
    }

    public function selectFormation($formationId)
    {
        $this->selectedFormation = Formation::with('positions')->find($formationId);
        $this->formationStep = 2;
    }

    public function updatePosition()
    {
        $this->validate(['position_id' => 'required|exists:positions,id']);
        Auth::user()->update(['position_id' => $this->position_id]);

        session()->flash('message', 'Formasi dan Jabatan berhasil diperbarui.');
        $this->switchSection('main');
    }

    public function render()
    {
        return view('livewire.student.profile.index', [
            'user' => Auth::user()->load('position.formation')
        ])->layout('components.layouts.app');
    }
}
