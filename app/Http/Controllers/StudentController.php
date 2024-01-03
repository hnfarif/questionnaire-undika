<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudyProgram;
use Illuminate\Contracts\View\View;

class StudentController extends Controller
{

    public function index(): View
    {
        $studyPrograms = StudyProgram::all();
        return view('student.index', compact('studyPrograms'));
    }
}
