<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Menangani permintaan registrasi pengguna baru.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'domicile' => ['required', 'string', 'max:255'],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
            'formation_id' => ['required', 'exists:formations,id'],
            'instansi' => ['required'],
            'jabatan' => ['required'],
            'phone_number' => ['required'], 
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), 'Data yang diberikan tidak valid.', Response::HTTP_UNPROCESSABLE_ENTITY); // 422
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'domicile' => $request->domicile,
            'position_id' => $request->position_id,
            'formation_id' => $request->formation_id,
            'instansi' => $request->instansi,
            'jabatan' => $request->jabatan,
            'phone_number' => $request->phone_number,
        ]);

        $user->assignRole('student');
        $user->sendEmailVerificationNotification();

        $token = $user->createToken('api-token')->plainTextToken;

        $data = [
            'user' => $user->fresh(),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return ResponseHelper::success($data, 'Registrasi berhasil. Silakan verifikasi email Anda.', Response::HTTP_CREATED); // 201
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return ResponseHelper::error(null, 'Email atau password salah.', Response::HTTP_UNAUTHORIZED);
        }

        if (!$user->hasVerifiedEmail()) {
            return ResponseHelper::error(null, 'Email Anda belum diverifikasi. Silakan periksa kotak masuk Anda.', Response::HTTP_FORBIDDEN); // 403
        }

        $token = $user->createToken('api-token')->plainTextToken;

        $data = [
            'user' => $user,
            'token' => $token,
        ];

        return ResponseHelper::success($data, 'Login berhasil');
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ResponseHelper::success(null, 'Logout berhasil');
    }
}
