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
        $questionnaires = Questionnaire::query()->whereHas('submissions')->get();
        $categories = Category::all();
        return view('dashboard.index', compact('questionnaires', 'categories'));
    }
}
