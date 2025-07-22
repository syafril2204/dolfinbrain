<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Route::middleware(['auth'])->group(function () {
Route::get('/dashboard', Dashboard::class)->name('dashboard');

// });
