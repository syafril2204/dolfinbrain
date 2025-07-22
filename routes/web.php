<?php

use App\Http\Controllers\Api\AuthController;
use App\Livewire\Admin\Positions\Index as PositionIndex;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Formations\Index as FormationIndex;
use App\Livewire\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/formations', FormationIndex::class)->name('formations.index');
        Route::get('/formations/{formation}/positions', PositionIndex::class)->name('positions.index');
    });
});
