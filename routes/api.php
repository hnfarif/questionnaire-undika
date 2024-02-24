<?php

use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionnaireController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::post('questionnaire/duplicate/{id}', [QuestionnaireController::class, 'duplicateQuestionnaire']);

    Route::apiResource('dashboard', DashboardController::class)->except(['show', 'store', 'update', 'destroy']);
    Route::apiResource('questionnaire', QuestionnaireController::class);
    Route::apiResource('question', QuestionController::class);
    Route::apiResource('submission', SubmissionController::class);
    Route::apiResource('answer', AnswerController::class);
    Route::apiResource('student', StudentController::class);
});

Route::apiResource('answer', AnswerController::class);
