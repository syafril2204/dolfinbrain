<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizPackageResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizPackageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->position_id) {
            dd('test');
            ResponseHelper::error(null, 'Anda belum memilih formasi/jabatan.', Response::HTTP_FORBIDDEN);
        }

        if (!$user->hasMaterialAccess()) {
            ResponseHelper::error(null, 'Akses ditolak. Silakan beli paket untuk mengakses soal ini.', Response::HTTP_FORBIDDEN);
        }

        $position = Position::with('quizPackages.questions')->find($user->position_id);

        if (!$position) {
            ResponseHelper::error(null, 'Posisi tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        $data = QuizPackageResource::collection($position->quizPackages);
        return ResponseHelper::success($data, 'Berhasil mengambil data paket kuis.');
    }
}
