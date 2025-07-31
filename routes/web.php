<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Admin\Formations\Index as FormationIndex;
use App\Livewire\Admin\Materials\Index as MaterialIndex;
use App\Livewire\Admin\Positions\Index as PositionIndex;
use App\Livewire\Student\Quiz\PackageIndex as StudentQuizIndex;
use App\Livewire\Student\Quiz\Attempt as StudentQuizAttempt;
use App\Livewire\Student\Profile\Index as StudentProfileIndex;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\Admin\Materials\Form as MaterialForm;
use App\Livewire\Admin\Quiz\Packages\Index as QuizPackageIndex;
use App\Livewire\Admin\Quiz\Packages\Form as QuizPackageForm;
use App\Livewire\Admin\Quiz\Questions\Index as QuestionIndex;
use App\Livewire\Admin\Quiz\Questions\Form as QuestionForm;
use App\Livewire\Student\Materials\Index as StudentMaterialIndex;
use App\Livewire\Admin\Lms\Spaces\Index as LmsSpaceIndex;
use App\Livewire\Admin\Lms\Spaces\Form as LmsSpaceForm;
use App\Livewire\Admin\Lms\Content\Index as LmsContentIndex;
use App\Livewire\Admin\Lms\Content\Coaching\Index as CoachingIndex;
use App\Livewire\Admin\Lms\Content\Coaching\Form as CoachingForm;
use App\Livewire\Admin\Lms\Content\Attachments as LmsContentAttachments;
use App\Livewire\Admin\Quiz\Packages\Show as QuizPackageShow;
use App\Livewire\Admin\Lms\Content\Videos\Index as VideoIndex;
use App\Livewire\Admin\Lms\Content\Videos\Form as VideoForm;
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
    Route::get('/register', Register::class)->name('register');
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


    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/formations', FormationIndex::class)->name('formations.index');
        Route::get('/formations/{formation}/positions', PositionIndex::class)->name('positions.index');
        Route::get('/materials', MaterialIndex::class)->name('materials.index');
        Route::get('/materials/create', MaterialForm::class)->name('materials.create');
        Route::get('/materials/{material}/edit', MaterialForm::class)->name('materials.edit');

        Route::prefix('lms-spaces')->name('lms-spaces.')->group(function () {
            Route::get('/', LmsSpaceIndex::class)->name('index');
            Route::get('/create', LmsSpaceForm::class)->name('create');
            Route::get('/{lms_space}/edit', LmsSpaceForm::class)->name('edit');

            Route::prefix('/{lms_space}/content')->name('content.')->group(function () {
                Route::get('/', LmsContentIndex::class)->name('index');

                Route::prefix('/videos')->name('videos.')->group(function () {
                    Route::get('/', VideoIndex::class)->name('index');
                    Route::get('/create', VideoForm::class)->name('create');
                    Route::get('/{video}/edit', VideoForm::class)->name('edit');
                });

                Route::prefix('/coaching')->name('coaching.')->group(function () {
                    Route::get('/', CoachingIndex::class)->name('index');
                    Route::get('/create', CoachingForm::class)->name('create');
                    Route::get('/{coaching}/edit', CoachingForm::class)->name('edit');
                });
                Route::get('/attachments', LmsContentAttachments::class)->name('attachments');
            });
        });

        Route::prefix('quiz-packages')->name('quiz-packages.')->group(function () {
            Route::get('/', QuizPackageIndex::class)->name('index');
            Route::get('/create', QuizPackageForm::class)->name('create');
            Route::get('/{quiz_package}/edit', QuizPackageForm::class)->name('edit');
            Route::get('/{quiz_package}', QuizPackageShow::class)->name('show');

            Route::prefix('/{quiz_package}/questions')->name('questions.')->group(function () {
                Route::get('/', QuestionIndex::class)->name('index');
                Route::get('/create', QuestionForm::class)->name('create');
                Route::get('/{question}/edit', QuestionForm::class)->name('edit');
            });
        });
    });
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/materi', StudentMaterialIndex::class)->name('materi.index');

        Route::get('/profile', StudentProfileIndex::class)->name('profile.index');

        Route::get('/soal', StudentQuizIndex::class)->name('soal.index');
        Route::get('/quiz/{quiz_package}/attempt', StudentQuizAttempt::class)->name('quiz.attempt');
    });
});
