<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\StudyProgram;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    public function index(): View
    {
        $studyPrograms = StudyProgram::all();
        return view('student.index', compact('studyPrograms'));
    }

    public function questionnaire(): View
    {
        $questionnaires = Questionnaire::whereStudyProgramId(Auth::user()
            ->student
            ->study_program_id)
            ->whereStatus("APPROVED")
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->get();

        $nim = Auth::user()->id;

        foreach ($questionnaires as $questionnaire) {
            $hasSubmission = Submission::query()
                ->where('questionnaire_id', $questionnaire->id)
                ->where('nim', $nim)->first();
            $questionnaire['hasSubmission'] = $hasSubmission ? true : false;
        }

        return view('student.questionnaire', compact('questionnaires'));
    }
}
