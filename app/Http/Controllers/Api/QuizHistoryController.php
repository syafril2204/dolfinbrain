<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizHistoryResource;
use Illuminate\Http\Request;

class QuizHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $attempts = $user->attempts()
            ->where('status', 'completed')
            ->with('quizPackage')
            ->latest('finished_at')
            ->paginate(10);

        $data = QuizHistoryResource::collection($attempts);

        return ResponseHelper::success($data, 'Berhasil mengambil riwayat pengerjaan kuis.');
    }
}
