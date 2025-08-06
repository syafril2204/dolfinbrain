<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\QuizPackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TripayCallbackController;
use App\Http\Resources\UserResource;

Route::post('/tripay/callback', [TripayCallbackController::class, 'handle'])->name('api.tripay.callback');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        $user = $request->user();

        $user->load('position.formation');

        return new UserResource($user);
    });


    Route::get('/materials', [MaterialController::class, 'index']);
    Route::get('/quiz-packages', [QuizPackageController::class, 'index']);
});
