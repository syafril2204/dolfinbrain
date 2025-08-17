<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\LmsSpaceResource;
use App\Models\LmsSpace;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LmsController extends Controller
{
    /**
     * Menampilkan daftar LMS Space yang dapat diakses oleh pengguna.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user->hasLmsAccess()) {
            return ResponseHelper::success([], 'Anda tidak memiliki akses ke fitur LMS.');
        }

        // Ambil LMS Spaces dari semua posisi yang pernah dibeli dengan paket 'bimbingan'
        $purchasedPositions = $user->purchasedPositions()->where('package_type', 'bimbingan')->pluck('id');
        $lmsSpaces = LmsSpace::whereHas('positions', function ($query) use ($purchasedPositions) {
            $query->whereIn('position_id', $purchasedPositions);
        })->where('is_active', true)->latest()->paginate(10);

        $data = LmsSpaceResource::collection($lmsSpaces);

        return ResponseHelper::success($data, 'Berhasil mengambil daftar LMS Space.');
    }

    /**
     * Menampilkan detail LMS Space beserta seluruh kontennya.
     */
    public function show(Request $request, LmsSpace $lms_space): JsonResponse
    {
        $user = $request->user();

        // 1. Cek apakah user punya akses umum ke LMS
        if (!$user->hasLmsAccess()) {
            return ResponseHelper::error(null, 'Akses ditolak. Fitur ini hanya untuk paket bimbingan.', Response::HTTP_FORBIDDEN);
        }

        // 2. Cek apakah user punya akses ke LMS Space spesifik ini
        $canAccess = $user->purchasedPositions()
            ->where('package_type', 'bimbingan')
            ->whereHas('lmsSpaces', fn($q) => $q->where('lms_space_id', $lms_space->id))
            ->exists();

        if (!$canAccess) {
             return ResponseHelper::error(null, 'Anda tidak memiliki akses ke LMS Space ini.', Response::HTTP_FORBIDDEN);
        }

        // Muat semua relasi konten
        $lms_space->load([
            'videos' => fn($q) => $q->orderBy('order'),
            'coachings' => fn($q) => $q->orderBy('start_at'),
            'resources', 'materials', 'quizPackages'
        ]);

        $data = new LmsSpaceResource($lms_space);

        return ResponseHelper::success($data, 'Berhasil mengambil detail LMS Space.');
    }
}
