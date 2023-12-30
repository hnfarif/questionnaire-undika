<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Semester;
use App\Models\StudyProgram;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $studyProgramId = StudyProgram::whereMngrId(auth()->user()->id)->first()->id ??
            StudyProgram::first()->id;
        $semester = Semester::whereStudyProgramId($studyProgramId)->first();

        return view("questionnaire.index", compact("semester"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $categories = Category::all();

        return view('questionnaire.detail', compact('questionnaire', 'categories'));
    }

    public function submit(string $id): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->status = 'SUBMITTED';
        $questionnaire->save();

        return back();
    }

    public function approve(string $id): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->status = 'APPROVED';
        $questionnaire->save();

        return back();
    }

    public function reject(string $id): RedirectResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->status = 'REJECTED';
        $questionnaire->save();

        return back();
    }
}
