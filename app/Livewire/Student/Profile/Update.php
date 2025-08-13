<?php

namespace App\Livewire\Student\Profile;

use App\Models\Formation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $activeTab = 'profile';

    public $name, $gender, $avatar;

    public $current_password, $password, $password_confirmation;

    public $formations = [];
    public $selectedFormation = null;
    public $new_position_id = null;
    public $formationStep = 1;
    public $date_of_birth, $domicile;

    public function mount(?string $status = null)
    {
        if ($status) {
            $this->activeTab = $status;
        }
        $user = Auth::user();
        $this->name = $user->name;
        $this->gender = $user->gender;
        if ($user->date_of_birth) {
            $this->date_of_birth = $user->date_of_birth->format('Y-m-d');
        }
        $this->domicile = $user->domicile;
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetErrorBag();

        if ($tab === 'formation') {
            // Data akan diisi saat tab ini diklik
            $this->formations = Formation::with('positions')->get();
            $this->formationStep = 1;
        }
    }

    public function updateProfile()
    {
        $user = Auth::user();
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($this->avatar) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validatedData['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($validatedData);
        session()->flash('message', 'Profil berhasil diperbarui.');
    }

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

    public function selectFormation($formationId)
    {
        $this->selectedFormation = Formation::with('positions')->find($formationId);
        $this->formationStep = 2;
    }

    public function updatePosition()
    {
        $validatedData = $this->validate([
            'new_position_id' => 'required|exists:positions,id',
        ]);

        Auth::user()->update([
            'position_id' => $validatedData['new_position_id'],
        ]);

        session()->flash('message', 'Formasi dan Jabatan berhasil diperbarui.');

        return $this->redirect(route('students.profile.update'), navigate: true);
    }

    public function render()
    {
        return view('livewire.student.profile.update')
            ->layout('components.layouts.app');
    }
}
