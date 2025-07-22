<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Admin\Formations\Index as FormationIndex;
use App\Livewire\Admin\Materials\Index as MaterialIndex;
use App\Livewire\Admin\Positions\Index as PositionIndex;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Admin\Materials\Form as MaterialForm;
use App\Models\Material;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/materials/download/{material}', function (Material $material) {
        if (Storage::exists($material->file_path)) {
            $originalName = pathinfo($material->file_path, PATHINFO_BASENAME);
            return Storage::download($material->file_path, $originalName);
        }
        abort(404, 'File not found.');
    })->name('materials.download');


    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/formations', FormationIndex::class)->name('formations.index');
        Route::get('/formations/{formation}/positions', PositionIndex::class)->name('positions.index');

        
        Route::get('/materials', MaterialIndex::class)->name('materials.index');
        Route::get('/materials/create', MaterialForm::class)->name('materials.create');
        Route::get('/materials/{material}/edit', MaterialForm::class)->name('materials.edit');
    });
});
