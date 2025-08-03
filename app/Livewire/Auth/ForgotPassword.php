<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class ForgotPassword extends Component
{
    public $email;
    public $status;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    protected $messages = [
        'email.required' => 'Alamat email harus diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.exists' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.',
    ];

    public function sendResetLink()
    {
        $this->validate();

        // Kirim link reset menggunakan sistem bawaan Laravel
        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status == Password::RESET_LINK_SENT) {
            $this->status = __($status);
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
