<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});

Auth::routes();

Route::middleware('ensureUserRole:PIMPINAN,DEKAN,KAPRODI')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('ensureUserRole:PIMPINAN,DEKAN,KAPRODI')->controller(QuestionnaireController::class)->group(function () {
    Route::get('/questionnaire', 'index')->name('questionnaire.index');
    Route::get('/questionnaire/pimpinan-dekan', 'questionnairePimpinanDekan')->name('questionnaire.pimpinan');
    Route::get('/questionnaire/{questionnaire}', 'show')->name('questionnaire.show');
    Route::patch('/questionnaire/{questionnaire}/submit', 'submit')->name('questionnaire.submit');
    Route::patch('/questionnaire/{questionnaire}/approve', 'approve')->name('questionnaire.approve');
    Route::patch('/questionnaire/{questionnaire}/reject', 'reject')->name('questionnaire.reject');
});

Route::middleware('ensureUserRole:MAHASISWA')->controller(QuestionController::class)->group(function () {
    Route::get('/question', 'index')->name('question.index');
});

Route::controller(SubmissionController::class)->group(function () {
    Route::middleware('ensureUserRole:PIMPINAN,DEKAN,KAPRODI')->get('/submission', 'index')->name('submission.index');
    Route::middleware('ensureUserRole:MAHASISWA')->post('/submission', 'store')->name('submission.store');
});

