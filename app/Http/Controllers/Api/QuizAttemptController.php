<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizAttemptResource;
use App\Models\QuizAttempt;
use App\Models\QuizPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class QuizAttemptController extends Controller
{

    public function start(Request $request, QuizPackage $quiz_package)
    {
        $user = $request->user();

        // if (!$user->hasMaterialAccess() || !$user->position->quizPackages->contains($quiz_package)) {
        //     ResponseHelper::error(null, 'Akses ditolak.', Response::HTTP_FORBIDDEN);
        // }

        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_package_id' => $quiz_package->id,
            'status' => 'in_progress',
        ]);

        return ResponseHelper::success(['attempt_id' => $attempt->id], 'Kuis berhasil dimulai.');
    }



    public function answer(Request $request, QuizAttempt $attempt)
    {
        if ($request->user()->id !== $attempt->user_id) {
            ResponseHelper::error(null, 'Tidak diizinkan.', Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
        ]);

        $attempt->details()->updateOrCreate(
            ['question_id' => $validated['question_id']],
            ['answer_id' => $validated['answer_id']]
        );

        return ResponseHelper::success(null, 'Jawaban berhasil disimpan.');
    }


    public function finish(Request $request, QuizAttempt $attempt)
    {
        if ($request->user()->id !== $attempt->user_id || $attempt->status !== 'in_progress') {
            ResponseHelper::error(null, 'Tidak diizinkan atau kuis sudah selesai.', Response::HTTP_FORBIDDEN);
        }

        $score = 0;
        $correctAnswers = 0;
        $totalQuestions = $attempt->quizPackage->questions()->count();

        DB::transaction(function () use ($attempt, &$correctAnswers) {
            $questions = $attempt->quizPackage->questions()->with('answers')->get();
            $userAnswers = $attempt->details->pluck('answer_id', 'question_id');

            foreach ($questions as $question) {
                $selectedAnswerId = $userAnswers[$question->id] ?? null;
                $correctAnswer = $question->answers->where('is_correct', true)->first();
                $isCorrect = ($selectedAnswerId && $correctAnswer && $selectedAnswerId == $correctAnswer->id);

                if ($isCorrect) {
                    $correctAnswers++;
                }

                $attempt->details()->where('question_id', $question->id)->update(['is_correct' => $isCorrect]);
            }
        });

        $score = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;
        $attempt->update([
            'score' => $score,
            'status' => 'completed',
            'finished_at' => now(),
        ]);

        $attempt->load('quizPackage.questions.answers', 'details');

        return ResponseHelper::success(new QuizAttemptResource($attempt), 'Kuis berhasil diselesaikan.');
    }

    public function result(Request $request, QuizAttempt $attempt)
    {
        if ($request->user()->id !== $attempt->user_id || $attempt->status !== 'completed') {
            return ResponseHelper::error(null, 'Tidak diizinkan atau kuis belum selesai.', 403);
        }

        $attempt->load('quizPackage.questions.answers', 'details');

        return ResponseHelper::success(new QuizAttemptResource($attempt), 'Berhasil mengambil hasil kuis.');
    }
}
