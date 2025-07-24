<?php

namespace App\Livewire\Auth;

use App\Enums\RoleEnum;
use App\Models\Formation;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Register extends Component
{
    public $step = 1;

    // Properti Step 1: Buat Akun
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    // Properti Step 2: Lengkapi Profil
    public $gender = '';
    public $date_of_birth = '';
    public $domicile = '';

    // Properti Step 3 & 4: Pilih Formasi & Posisi
    public $formations;
    public $selectedFormation = null;
    public $position_id = null;

    // Memeriksa session saat komponen dimuat
    public function mount()
    {
        if (session()->has('user_id_for_registration')) {
            $user = User::find(session('user_id_for_registration'));

            if (!$user) {
                $this->resetRegistrationSession();
                return;
            }

            // Ambil data yang sudah ada untuk mengisi form
            $this->name = $user->name;
            $this->email = $user->email;
            $this->gender = $user->gender;
            $this->date_of_birth = $user->date_of_birth;
            $this->domicile = $user->domicile;
            $this->position_id = $user->position_id;

            // Ambil langkah terakhir dari session, default ke langkah 2
            $this->step = session('registration_step', 2);

            // Jika refresh di step 4 (pilih posisi), kita perlu muat ulang data $selectedFormation
            if ($this->step == 4 && $user->position_id) {
                $position = Position::with('formation')->find($user->position_id);
                if ($position) {
                    $this->selectedFormation = $position->formation;
                }
            } else if ($this->step == 4 && !$user->position_id) {
                // Jika user merefresh halaman di step 4 tapi belum memilih posisi,
                // kita perlu tahu formasi apa yang sedang dipilih.
                // Logika ini bisa menjadi kompleks, untuk sementara kita arahkan kembali ke step 3.
                $this->step = 3;
                session(['registration_step' => 3]);
            }
        }
    }

    // STEP 1: Buat user, JANGAN login, simpan ID ke session
    public function submitStep1()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $user->assignRole(RoleEnum::STUDENT->value);

        session(['user_id_for_registration' => $user->id]);

        $this->step = 2;
        session(['registration_step' => 2]);
    }

    // STEP 2: Ambil user dari session, update profil, lanjut ke Step 3
    public function submitStep2()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'date_of_birth' => 'required|date',
            'domicile' => 'required|string|max:255',
        ]);

        $userId = session('user_id_for_registration');
        if ($userId) {
            $user = User::find($userId);
            $user->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'domicile' => $this->domicile,
            ]);
        }

        $this->step = 3;
        session(['registration_step' => 3]);
    }

    // STEP 3: Pilih formasi, lanjut ke Step 4
    public function selectFormation($formationId)
    {
        $this->selectedFormation = Formation::with('positions')->find($formationId);
        $this->step = 4;
        session(['registration_step' => 4]);
    }

    // STEP 4: Ambil user dari session, update posisi, LOGIN, lalu redirect
    public function submitStep4()
    {
        $this->validate(['position_id' => 'required|exists:positions,id']);

        $userId = session('user_id_for_registration');
        if ($userId) {
            $user = User::find($userId);
            $user->update(['position_id' => $this->position_id]);

            // Login user setelah semua langkah selesai
            Auth::login($user);

            // Hapus session setelah tidak dibutuhkan lagi
            $this->resetRegistrationSession();

            return redirect()->route('dashboard');
        }

        // Jika session tidak ada karena suatu hal, kembalikan ke awal
        return redirect()->route('register');
    }

    // Kembali ke langkah sebelumnya
    public function back()
    {
        if ($this->step > 1) {
            $this->step--;
            session(['registration_step' => $this->step]);
        }
    }

    // Helper untuk membersihkan session
    public function resetRegistrationSession()
    {
        session()->forget('user_id_for_registration');
        session()->forget('registration_step');
    }

    public function render()
    {
        // Muat data formasi hanya saat di Step 3
        if ($this->step == 3) {
            $this->formations = Formation::all();
        }

        return view('livewire.auth.register');
    }
}
