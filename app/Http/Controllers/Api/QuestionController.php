<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\QuizPackage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    public function index(Request $request, QuizPackage $quiz_package)
    {
        $user = $request->user();

    // if (!$user->hasMaterialAccess()) {
    //     ResponseHelper::error(null, 'Akses ditolak. Silakan beli paket untuk mengakses soal ini.', Response::HTTP_FORBIDDEN);
    // }

        $isAssigned = $user->position->quizPackages()->where('quiz_package_id', $quiz_package->id)->exists();
        if (!$isAssigned) {
            ResponseHelper::error(null, 'Paket kuis ini tidak tersedia untuk formasi Anda.', Response::HTTP_FORBIDDEN);
        }

        $questions = $quiz_package->questions()->with('answers')->get();

        $data = QuestionResource::collection($questions);
        return ResponseHelper::success($data, 'Berhasil mengambil data soal.');
    }
}
