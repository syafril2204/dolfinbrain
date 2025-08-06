<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper; // <-- 1. Import helper Anda
use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->position_id) {
            ResponseHelper::error(null, 'Anda belum memilih formasi/jabatan.', Response::HTTP_FORBIDDEN);
        }

        if (!$user->hasMaterialAccess()) {
            ResponseHelper::error(null, 'Akses ditolak. Silakan beli paket untuk mengakses materi ini.', Response::HTTP_FORBIDDEN);
        }

        $position = Position::with('materials')->find($user->position_id);

        if (!$position) {
            ResponseHelper::error(null, 'Posisi tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        // 4. Kembalikan data sukses menggunakan ResponseHelper
        $data = MaterialResource::collection($position->materials);
        return ResponseHelper::success($data, 'Berhasil mengambil data materi.');
    }
}
