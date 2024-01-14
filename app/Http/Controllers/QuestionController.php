<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Submission;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuestionController extends Controller
{

    /**
     * @throws Exception
     */
    public function index(Request $request): View
    {

        if (!$request->has('questionnaireId')) {
            abort(404);
        }

        $questionnaireId = $request->questionnaireId;

        $nim = Auth::user()->student->nim;
        $isAnswered = Submission::whereQuestionnaireId($questionnaireId)->whereNim($nim)->first();

        $questionnaire = Questionnaire::findOrFail($questionnaireId);

        $startDate = Carbon::create($questionnaire->start_date);
        $endDate = Carbon::create($questionnaire->end_date)->addDays(1);
        $now = Carbon::now();
        $isActive = $now >= $startDate && $now <= $endDate;
        $questions = Question::where('questionnaire_id', '=', $questionnaire->id)->get();

        if ($questionnaire->status != 'APPROVED' || !$isActive) {
            abort(404);
        }

        return view('questionnaire.question', compact('questionnaire', 'questions', 'isAnswered'));
    }
}
