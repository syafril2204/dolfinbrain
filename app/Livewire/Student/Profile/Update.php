<?php

namespace App\Livewire\Student\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads; // <-- Tambahkan ini untuk upload file

class Update extends Component
{
    use WithFileUploads; // <-- Gunakan trait ini

    // Properti untuk mengontrol tab yang aktif
    public $activeTab = 'profile';

    // Properti untuk Ubah Profile
    public $name, $gender, $date_of_birth, $domicile;
    public $avatar; // Properti baru untuk file upload

    // Properti untuk Ubah Password
    public $current_password, $password, $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->gender = $user->gender;
        if ($user->date_of_birth) {
            $this->date_of_birth = $user->date_of_birth->format('Y-m-d');
        }
        $this->domicile = $user->domicile;
    }

    // Fungsi untuk berganti tab
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetErrorBag(); // Hapus pesan error lama saat ganti tab
    }

    // Fungsi untuk menyimpan perubahan profil
    public function updateProfile()
    {
        $user = Auth::user();
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'date_of_birth' => 'required|date',
            'domicile' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048', // Validasi avatar: gambar, max 2MB
        ]);

        // Logika untuk upload avatar
        if ($this->avatar) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Simpan avatar baru
            $validatedData['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($validatedData);
        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    // Fungsi untuk menyimpan password baru
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
    }

    public function render()
    {
        return view('livewire.student.profile.update')
            ->layout('components.layouts.app');
    }
}
