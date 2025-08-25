<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetCodeMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordResetController extends Controller
{
    /**
     * Langkah 1: Minta kode reset dan kirim ke email.
     */
    public function sendCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), 'Email tidak ditemukan.', 404);
        }

        // Hapus token lama jika ada
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Buat kode 6 digit
        $code = random_int(100000, 999999);

        // Simpan kode ke database
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $code, // Simpan kode mentah, bukan hash
            'created_at' => Carbon::now()
        ]);

        // Kirim email
        try {
            Mail::to($request->email)->send(new PasswordResetCodeMail($code));
        } catch (\Exception $e) {
            return ResponseHelper::error(null, 'Gagal mengirim email. Coba lagi nanti.', 500);
        }

        return ResponseHelper::success(null, 'Kode reset password telah dikirim ke email Anda.');
    }

    /**
     * Langkah 2: Verifikasi kode yang dimasukkan pengguna.
     */
    public function verifyCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), 'Data tidak valid.', 422);
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        // Cek jika record tidak ada atau sudah lebih dari 10 menit
        if (!$record || Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return ResponseHelper::error(null, 'Kode tidak valid atau telah kedaluwarsa.', 422);
        }

        return ResponseHelper::success(['valid' => true], 'Kode valid.');
    }


    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required|numeric',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), 'Data tidak valid.', 422);
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return ResponseHelper::error(null, 'Kode tidak valid atau telah kedaluwarsa.', 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return ResponseHelper::success(null, 'Password berhasil direset.');
    }
}
