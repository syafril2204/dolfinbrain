<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('Login')]
class Login extends Component
{
    #[Rule('required|email')]
    public $email = '';

    #[Rule('required')]
    public $password = '';

    #[Rule('boolean')]
    public $remember = false;


    public function attemptLogin()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            return $this->redirectRoute('dashboard', navigate: true);
        }
        if (!$user->hasVerifiedEmail()) {
            $this->addError('email', 'Email Anda belum diverifikasi. Silakan periksa kotak masuk Anda.'); // 403
        }

        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
