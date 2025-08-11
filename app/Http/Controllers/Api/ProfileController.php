<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan data profil pengguna saat ini.
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('position.formation', 'purchasedPositions.formation');
        return ResponseHelper::success(new UserResource($user), 'Profil berhasil diambil.');
    }

    /**
     * Memperbarui data profil dasar (nama, gender, dll).
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'date_of_birth' => 'required|date',
            'domicile' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|max:2048', // 2MB
        ]);

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Simpan avatar baru
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return ResponseHelper::success(new UserResource($user), 'Profil berhasil diperbarui.');
    }

    /**
     * Mengubah password pengguna.
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return ResponseHelper::success(null, 'Password berhasil diubah.');
    }

    /**
     * Mengubah jabatan aktif pengguna.
     */
    public function changePosition(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'position_id' => 'required|exists:positions,id',
        ]);

        // Cek apakah pengguna sudah membeli jabatan yang akan diaktifkan
        $hasPurchased = $user->purchasedPositions()->where('position_id', $validated['position_id'])->exists();

        if (!$hasPurchased) {
            // Jika jabatan yang dipilih adalah jabatan default (saat register) dan belum ada pembelian, izinkan.
            if ($user->purchasedPositions()->count() === 0 && $user->position_id == $validated['position_id']) {
                 // Tidak melakukan apa-apa, karena sudah aktif
            } else {
                return ResponseHelper::error(null, 'Anda belum membeli paket untuk jabatan ini.', 403);
            }
        }

        $user->update(['position_id' => $validated['position_id']]);

        return ResponseHelper::success(new UserResource($user->fresh('position.formation')), 'Jabatan aktif berhasil diubah.');
    }
}
