<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Admin\Formations\Index as FormationIndex;
use App\Livewire\Admin\Materials\Index as MaterialIndex;
use App\Livewire\Admin\Positions\Index as PositionIndex;
use App\Livewire\Student\Quiz\PackageIndex as StudentQuizIndex;
use App\Livewire\Student\Quiz\Attempt as StudentQuizAttempt;
use App\Livewire\Student\Profile\Index as StudentProfileIndex;
use App\Livewire\Student\Profile\Update as StudentProfileUpdate;
use App\Livewire\Student\Transactions\Index as StudentTransactionIndex;
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
use App\Livewire\Student\Packages\Index as StudentPackageIndex;
use App\Livewire\Student\Lms\Index as LmsIndex;
use App\Livewire\Student\Lms\Show as LmsShow;
use App\Livewire\Admin\Lms\Content\Coaching\Index as CoachingIndex;
use App\Livewire\Admin\Lms\Content\Coaching\Form as CoachingForm;
use App\Livewire\Admin\Lms\Content\Attachments as LmsContentAttachments;
use App\Livewire\Admin\Quiz\Packages\Show as QuizPackageShow;
use App\Livewire\Admin\Lms\Content\Videos\Index as VideoIndex;
use App\Livewire\Student\Packages\Instruction as StudentPackageInstruction;
use App\Livewire\Admin\Lms\Content\Videos\Form as VideoForm;
use App\Livewire\Admin\Lms\Content\Files as LmsContentFiles;
use App\Livewire\Admin\Users\Index as UserIndex;
use App\Livewire\Student\Packages\Checkout as StudentPackageCheckout;
use App\Livewire\Student\Lms\Content\Materials as LmsMaterials;
use App\Livewire\Student\Lms\Content\Coaching as LmsCoaching;
use App\Livewire\Student\Lms\Content\Videos as LmsVideos;
use App\Livewire\Student\Lms\Content\Quizzes as LmsQuizzes;
use App\Livewire\Student\Lms\Content\Files as LmsFiles;
use App\Livewire\Student\Lms\Content\Audio as LmsAudio;
use App\Http\Controllers\Auth\GoogleController;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Student\Contact\Index as StudentContactIndex;
use App\Livewire\Student\MyPackages\Index as MyPackagesIndex;
use App\Models\Material;
use Illuminate\Support\Facades\Route;
use App\Models\LmsResource;
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

    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');

    Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
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

    Route::get('/lms-resources/download/{resource}', function (LmsResource $resource) {
        if (Storage::disk('public')->exists($resource->file_path)) {
            return Storage::disk('public')->download($resource->file_path, $resource->title . '.' . $resource->file_type);
        }
        abort(404, 'File tidak ditemukan.');
    })->name('admin.lms-resources.download');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        Route::get('/users', UserIndex::class)->name('users.index');
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
                Route::get('/files', LmsContentFiles::class)->name('files.index');
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

        Route::get('/profile', StudentProfileIndex::class)->name('profile.index');
        Route::get('/profile-update', StudentProfileUpdate::class)->name('profile.update');
        Route::middleware('profile.completed')->group(function () {

            Route::get('/kontak', StudentContactIndex::class)->name('contact.index');
            Route::get('/materi', StudentMaterialIndex::class)->name('materi.index');


            Route::get('/lms-space', LmsIndex::class)->name('lms.index');
            Route::get('/lms-space/{lms_space}', LmsShow::class)->name('lms.show');
            Route::prefix('/lms-space/{lms_space}')->name('lms.content.')->group(function () {
                Route::get('/materials', LmsMaterials::class)->name('materials');
                Route::get('/coaching', LmsCoaching::class)->name('coaching');
                Route::get('/videos', LmsVideos::class)->name('videos');
                Route::get('/quizzes', LmsQuizzes::class)->name('quizzes');
                Route::get('/files', LmsFiles::class)->name('files');
                Route::get('/audio', LmsAudio::class)->name('audio');
            });

            Route::get('/paket-saya', MyPackagesIndex::class)->name('my-packages.index');
            Route::get('/beli-paket', StudentPackageIndex::class)->name('packages.index');
            Route::get('/instruction/{transaction:reference}', StudentPackageInstruction::class)->name('packages.instruction');
            Route::get('/checkout/{package_type}', StudentPackageCheckout::class)->name('packages.checkout');

            Route::get('/history-pembelian', StudentTransactionIndex::class)->name('transactions.index');
            Route::get('/soal', StudentQuizIndex::class)->name('soal.index');
            Route::get('/quiz/{quiz_package}/attempt', StudentQuizAttempt::class)->name('quiz.attempt');
        });
    });
});
