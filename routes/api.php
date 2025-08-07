<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuizAttemptController;
use App\Http\Controllers\Api\QuizHistoryController;
use App\Http\Controllers\Api\QuizPackageController;
use App\Http\Controllers\Api\TransactionHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TripayCallbackController;
use App\Http\Resources\UserResource;

Route::post('/tripay/callback', [TripayCallbackController::class, 'handle'])->name('api.tripay.callback');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::post('/update', [ProfileController::class, 'update']);
        Route::post('/change-password', [ProfileController::class, 'changePassword']);
        Route::post('/change-position', [ProfileController::class, 'changePosition']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        $user = $request->user();

        $user->load('position.formation');

        return new UserResource($user);
    });


    Route::get('/materials', [MaterialController::class, 'index']);

    Route::get('/quiz-packages', [QuizPackageController::class, 'index']);
    Route::get('/quiz-packages/{quiz_package}', [QuizPackageController::class, 'show']);

    Route::post('/quiz-packages/{quiz_package}/start', [QuizAttemptController::class, 'start']);
    Route::post('/quiz-attempts/{attempt}/answer', [QuizAttemptController::class, 'answer']);
    Route::post('/quiz-attempts/{attempt}/finish', [QuizAttemptController::class, 'finish']);
    Route::get('/quiz-attempts/{attempt}/result', [QuizAttemptController::class, 'result']);
    Route::get('/quiz-history', [QuizHistoryController::class, 'index']);

    Route::get('/transactions', [TransactionHistoryController::class, 'index']);
    Route::get('/quiz-attempts/{attempt}/result', [App\Http\Controllers\Api\QuizAttemptController::class, 'result'])->name('api.quiz.result');
});
