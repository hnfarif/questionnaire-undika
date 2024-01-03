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

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->controller(QuestionnaireController::class)->group(function () {
    Route::get('/questionnaire', 'index')->name('questionnaire.index');
    Route::get('/questionnaire/{questionnaire}', 'show')->name('questionnaire.show');
    Route::patch('/questionnaire/{questionnaire}/submit', 'submit')->name('questionnaire.submit');
    Route::patch('/questionnaire/{questionnaire}/approve', 'approve')->name('questionnaire.approve');
    Route::patch('/questionnaire/{questionnaire}/reject', 'reject')->name('questionnaire.reject');
});

Route::middleware('auth')->controller(QuestionController::class)->group(function () {
    Route::get('/question', 'index')->name('question.index');
});

Route::middleware('auth')->controller(SubmissionController::class)->group(function () {
    Route::get('/submission', 'index')->name('submission.index');
    Route::post('/submission', 'store')->name('submission.store');
});

Route::middleware('auth')->controller(StudentController::class)->group(function () {
    Route::get('/student', 'index')->name('student.index');
});
