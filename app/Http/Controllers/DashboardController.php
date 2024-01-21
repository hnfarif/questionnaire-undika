<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Questionnaire;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\Submission;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        $studyProgramId = [];

        if (Auth::user()->roles->first()->name == 'PIMPINAN') {
            $studyProgramId = StudyProgram::all()->pluck("id")->toArray();
        }

        if (Auth::user()->roles->first()->name == 'DEKAN') {
            $studyProgramId = StudyProgram::whereFacultyId(Auth::user()->employee->faculty->id)->get()
                ->pluck("id")->toArray();
        }

        if (Auth::user()->roles->first()->name == 'KAPRODI') {
            $studyProgramId[] = Auth::user()->employee->studyProgram->id;
        }


        $questionnaires = Questionnaire::whereStatus('APPROVED')->studyProgram($studyProgramId)->get();
        $categories = Category::all();
        return view('dashboard.index', compact('questionnaires', 'categories'));
    }
}
