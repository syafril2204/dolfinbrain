<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // <-- Pastikan model User di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * Tandai email pengguna sebagai terverifikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string  $hash
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request, $id, $hash)
    {

        $user = User::find($id);

        if (! $user || ! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('status', 'Email Anda sudah terverifikasi. Silakan login.');
        }

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Email Anda berhasil diverifikasi! Selamat datang.');
    }
}
