<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionnaireController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->controller(QuestionnaireController::class)->group(function () {
    Route::get('questionnaire', 'index')->name('questionnaire.index');
    Route::get('questionnaire/{id}', 'show')->name('questionnaire.show');
    Route::get('questionnaire/{id}/question', 'question')->name('questionnaire.question');
    Route::post('questionnaire/{id}/answer', 'answer')->name('questionnaire.answer');
    Route::patch('questionnaire/{id}/submit', 'submit')->name('questionnaire.submit');
    Route::patch('questionnaire/{id}/approve', 'approve')->name('questionnaire.approve');
    Route::patch('questionnaire/{id}/reject', 'reject')->name('questionnaire.reject');
});
