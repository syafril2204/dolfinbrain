<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\LMSCoachingResource;
use App\Http\Resources\LmsResourceResource;
use App\Http\Resources\LmsSpaceResource;
use App\Http\Resources\LMSVideoResource;
use App\Http\Resources\MaterialResource;
use App\Http\Resources\QuizPackageResource;
use App\Models\LmsSpace;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LmsController extends Controller
{

    /**
     * Helper untuk memeriksa otorisasi akses ke LMS Space.
     */
    private function authorizeAccess(User $user, LmsSpace $lms_space): bool
    {
        if (!$user->hasLmsAccess()) {
            return false;
        }

        return $user->purchasedPositions()
            ->where('package_type', 'bimbingan')
            ->whereHas('lmsSpaces', fn($q) => $q->where('lms_space_id', $lms_space->id))
            ->exists();
    }
    /**
     * Menampilkan daftar LMS Space yang dapat diakses oleh pengguna.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user->hasLmsAccess()) {
            return ResponseHelper::success([], 'Anda tidak memiliki akses ke fitur LMS.');
        }

        $purchasedPositionIds = $user->purchasedPositions()
            ->where('package_type', 'bimbingan')
            ->pluck('positions.id');

        $lmsSpaces = LmsSpace::whereHas('positions', function ($query) use ($purchasedPositionIds) {
            $query->whereIn('position_id', $purchasedPositionIds);
        })->where('is_active', true)->latest()->paginate(10);

        $data = LmsSpaceResource::collection($lmsSpaces);

        return ResponseHelper::success($data, 'Berhasil mengambil daftar LMS Space.');
    }


    /**
     * Menampilkan daftar audio untuk sebuah LMS Space.
     */
    public function audio(Request $request, LmsSpace $lms_space): JsonResponse
    {
        if (!$this->authorizeAccess($request->user(), $lms_space)) {
            return ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        }

        $audioFiles = $lms_space->resources()
            ->where('type', 'audio_recording') // Filter hanya untuk audio
            ->latest()
            ->paginate(10);

        return ResponseHelper::success(LmsResourceResource::collection($audioFiles), 'Berhasil mengambil daftar audio.');
    }
    /**
     * Menampilkan detail LMS Space beserta seluruh kontennya.
     */
    public function show(Request $request, LmsSpace $lms_space): JsonResponse
    {
        if (!$this->authorizeAccess($request->user(), $lms_space)) {
            return ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        }

        $lms_space->load(['videos', 'coachings', 'resources', 'materials', 'quizPackages']);
        return ResponseHelper::success(new LmsSpaceResource($lms_space), 'Berhasil mengambil detail LMS Space.');
    }

    /**
     * Menampilkan daftar video untuk sebuah LMS Space.
     */
    public function videos(Request $request, LmsSpace $lms_space): JsonResponse
    {
        if (!$this->authorizeAccess($request->user(), $lms_space)) {
            return ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        }

        $videos = $lms_space->videos()->orderBy('order')->paginate(10);
        return ResponseHelper::success(LMSVideoResource::collection($videos), 'Berhasil mengambil daftar video.');
    }

    /**
     * Menampilkan daftar jadwal coaching untuk sebuah LMS Space.
     */
    public function coachings(Request $request, LmsSpace $lms_space): JsonResponse
    {
        if (!$this->authorizeAccess($request->user(), $lms_space)) {
            return ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        }

        $coachings = $lms_space->coachings()->orderBy('start_at')->paginate(10);
        return ResponseHelper::success(LMSCoachingResource::collection($coachings), 'Berhasil mengambil daftar coaching.');
    }



    /**
     * Menampilkan daftar file & audio untuk sebuah LMS Space.
     */
    public function files(Request $request, LmsSpace $lms_space): JsonResponse
    {
        if (!$this->authorizeAccess($request->user(), $lms_space)) {
            return ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        }

        $files = $lms_space->resources()->latest()->paginate(10);
        return ResponseHelper::success(LmsResourceResource::collection($files), 'Berhasil mengambil daftar file.');
    }

    /**
     * Menampilkan daftar materi untuk sebuah LMS Space.
     */
    public function materials(Request $request, LmsSpace $lms_space): JsonResponse
    {
        if (!$this->authorizeAccess($request->user(), $lms_space)) {
            return ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        }

        $materials = $lms_space->materials()->latest()->paginate(10);
        return ResponseHelper::success(MaterialResource::collection($materials), 'Berhasil mengambil daftar materi.');
    }

    /**
     * Menampilkan daftar paket kuis untuk sebuah LMS Space.
     */
    public function quizzes(Request $request, LmsSpace $lms_space): JsonResponse
    {
        if (!$this->authorizeAccess($request->user(), $lms_space)) {
            return ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        }

        $quizzes = $lms_space->quizPackages()->latest()->paginate(10);
        return ResponseHelper::success(QuizPackageResource::collection($quizzes), 'Berhasil mengambil daftar kuis.');
    }
}
