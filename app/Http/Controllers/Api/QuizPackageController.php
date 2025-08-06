<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizPackageResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class QuizPackageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->position_id) {
            ResponseHelper::error(null, 'Anda belum memilih formasi/jabatan.', Response::HTTP_FORBIDDEN);
        }

        $position = Position::with('quizPackages.questions')->find($user->position_id);

        if (!$position) {
            ResponseHelper::error(null, 'Posisi tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }


        $quiz_packages = $position->quizPackages;

        $data = QuizPackageResource::collection($quiz_packages)->resolve();

        if (!$quiz_packages->isEmpty()) {
            $firstMaterial = $quiz_packages->first();
            if ($firstMaterial) {
                $data[0]['download_url'] = url(Storage::url($firstMaterial->file_path));
            }
        }
        return ResponseHelper::success($data, 'Berhasil mengambil data paket kuis.');
    }
}
