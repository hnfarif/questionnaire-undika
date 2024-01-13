<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Questionnaire;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        $numberOfSubmissions = Submission::count();
        $numberOfStudents = Student::count();
        $questionnaires = Questionnaire::query()->whereHas('submissions')->get();
        $categories = Category::all();
        $smt_active = Semester::orderBy('smt_active', 'desc')->first()->smt_active;
        return view('dashboard.index', compact('numberOfSubmissions', 'numberOfStudents', 'questionnaires', 'categories', 'smt_active'));
    }
}
