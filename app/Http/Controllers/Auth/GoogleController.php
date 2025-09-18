<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]
            );

            if ($user->wasRecentlyCreated) {
                $user->assignRole('student');
            }

            Auth::login($user);
            if ($user->status == 'blocked') {
                if (request()->expectsJson()) {
                    return ResponseHelper::error(null, 'Gagal login, akun anda diblokir');
                } else {
                    return redirect()->route('login')->with('error', 'Gagal login, akun anda diblokir.');
                }
            }

            if ($user->position_id) {
                if (request()->expectsJson()) {
                    $apiToken = $user->createToken('google-login-token')->plainTextToken;

                    $responseData = [
                        'token' => $apiToken,
                        'user' => $user,
                        'profile_complete' => !is_null($user->position_id)
                    ];

                    return ResponseHelper::success($responseData, 'Login berhasil.');
                } else {
                    return redirect()->route('dashboard');
                }
            } else {
                if (request()->expectsJson()) {
                    return ResponseHelper::error('Akun anda belum memiliki posisi');
                } else {
                    return redirect()->route('register');
                }
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return ResponseHelper::error('Gagal login dengan Google');
            } else {
                return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
            }
        }
    }
}
