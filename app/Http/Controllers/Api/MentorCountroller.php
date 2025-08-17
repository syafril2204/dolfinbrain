<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\MentorResource;
use App\Models\Mentor;
use Illuminate\Http\JsonResponse;

class MentorController extends Controller
{
    /**
     * Menampilkan daftar semua mentor.
     */
    public function index(): JsonResponse
    {
        // Ambil data mentor & relasinya untuk menghindari N+1 query problem
        $mentors = Mentor::with('position.formation')->latest()->get();

        $data = MentorResource::collection($mentors);

        return ResponseHelper::success($data, 'Berhasil mengambil data mentor.');
    }
}
