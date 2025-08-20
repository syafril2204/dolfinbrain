<?php

namespace App\Livewire\Auth;

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

    public $name = '';
    public $email = '';
    public $password = '';
    public $phone_number = '';
    public $password_confirmation = '';

    public $formation_id = '';
    public $instansi = '';
    public $jabatan = '';

    public $gender = '';
    public $date_of_birth = '';
    public $domicile = '';

    public $formations;
    public $selectedFormation = null;
    public $position_id = null;

    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user->position_id) {
                $this->step = 2;
                $this->name = $user->name;
                $this->email = $user->email;
            } else {
                return redirect()->route('dashboard');
            }
            return;
        }

        if (session()->has('user_id_for_registration')) {
            $user = User::find(session('user_id_for_registration'));
            if (!$user) {
                $this->resetRegistrationSession();
                return;
            }

            $this->name = $user->name;
            $this->email = $user->email;
            $this->gender = $user->gender;
            $this->date_of_birth = $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : null;
            $this->domicile = $user->domicile;
            $this->position_id = $user->position_id;
            $this->step = session('registration_step', 2);

            if (($this->step == 4 || $this->step == 5) && $user->position_id) {
                $position = Position::with('formation')->find($user->position_id);
                if ($position) {
                    $this->selectedFormation = $position->formation;
                }
            }
        }
    }

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

        $user->assignRole('student');

        session(['user_id_for_registration' => $user->id]);

        $this->step = 2;
        session(['registration_step' => 2]);
    }

    public function submitStep2()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'date_of_birth' => 'required|date',
            'domicile' => 'required|string|max:255',
            'phone_number' => 'required'
        ]);

        $userId = session('user_id_for_registration') ?? Auth::id();
        if ($userId) {
            $user = User::find($userId);
            $user->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'domicile' => $this->domicile,
                'phone_number' => $this->phone_number
            ]);
        }

        $this->step = 3;
        session(['registration_step' => 3]);
    }

    public function submitStep3()
    {
        $this->validate([
            'formation_id' => 'required',
            'instansi' => 'required',
            'jabatan' => 'required',
        ]);

        $userId = session('user_id_for_registration') ?? Auth::id();
        if ($userId) {
            $user = User::find($userId);
            $user->update([
                'formation_id' => $this->formation_id,
                'instansi' => $this->instansi,
                'jabatan' => $this->jabatan,
            ]);
        }
        $this->step = 4;
        session(['registration_step' => 4]);
    }
    public function selectFormation($formationId)
    {
        $this->selectedFormation = Formation::with('positions')->find($formationId);
        $this->step = 5;
        session(['registration_step' => 5]);
    }

    public function submitStep4()
    {
        $this->validate(['position_id' => 'required|exists:positions,id']);

        $userId = session('user_id_for_registration') ?? Auth::id();
        if ($userId) {
            $user = User::find($userId);
            $user->update(['position_id' => $this->position_id]);

            $user->sendEmailVerificationNotification();

            session()->flash('status', 'Pendaftaran hampir selesai! Link verifikasi telah dikirim ke email Anda. Silakan cek kotak masuk/spam.');

            $this->step = 6;
            session(['registration_step' => 6]);

            return;
        }

        return redirect()->route('register');
    }

    public function resendVerificationEmail()
    {
        $userId = session('user_id_for_registration') ?? Auth::id();
        if ($userId) {
            $user = User::find($userId);
            if ($user && !$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
                session()->flash('status', 'Link verifikasi baru telah dikirim ke email Anda!');
            }
        }
    }

    public function back()
    {
        if ($this->step == 6) {
            $this->step = 5;
            session(['registration_step' => 5]);
        } else if ($this->step > 1) {
            $this->step--;
            session(['registration_step' => $this->step]);
        }
    }

    public function resetRegistrationSession()
    {
        session()->forget(['user_id_for_registration', 'registration_step']);
    }

    public function render()
    {
        if ($this->step == 3 || $this->step == 4) {
            $this->formations = Formation::all();
        }
        return view('livewire.auth.register');
    }
}
