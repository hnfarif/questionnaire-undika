<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(Request $request): View
    {
        if (!$request->has('questionnaireId')) {
            abort(404);
        }

        $questionnaireId = $request->questionnaireId;
        $submissions = Submission::where('questionnaire_id', '=', $questionnaireId)
            ->with(['student', 'answers.question.category'])
            ->get();
        $questions = Question::where('questionnaire_id', '=', $questionnaireId)->get();

        $categories = Category::orderBy('id', 'asc')->get();

        // dd($this->getRxy($questions, $submissions));

        return view('submission.index', compact('submissions', 'questions', 'categories'));
    }

    private function getRxy($questions, $submissions)
    {
        $listRxy = [];
        $n = $submissions->count(); //benar

        foreach ($questions as $question) {
            $xi = 0; // benar
            $sumyi = 0; // benar
            $sumxi = 0;
            $sumxiyi = 0;
            $sumxi2 = 0;
            $sumyi2 = 0;

            $answers = Answer::query()
                ->with(['question', 'submission'])
                ->where('question_id', '=', $question->id)
                ->whereHas('question', function ($subQuery) use ($question) {
                    $subQuery->where('category_id', $question->category_id);
                })
                ->get();
            $xi = $answers->sum('scale');

            foreach ($answers as $answer) {
                $yi = Answer::query()
                    ->with(['question', 'submission'])
                    ->whereHas('submission', function ($subQuery) use ($answer) {
                        $subQuery->where('nim', $answer->submission->nim);
                    })
                    ->whereHas('question', function ($subQuery) use ($answer) {
                        $subQuery->where('category_id', $answer->question->category_id);
                    })
                    ->sum('scale');
                $sumyi += $yi * $answer->scale;
                $sumxiyi += $sumyi * $answer->scale;
                $sumxi2 += pow(2, $answer->scale);
                $sumyi2 += pow(2, $yi);
            }

            $sumxi = pow(2, $xi);
            $powsumyi = pow(2, $sumyi);
            $numerator = $n * $sumxiyi - ($xi * $sumyi);
            $denominator = sqrt(($n * $sumxi2 - $sumxi) * ($n * $sumyi2 - $powsumyi));

            $rxy = $numerator / $denominator;
            $listRxy[$question->id] = $rxy;
            // return $sumxi;
        }

        return $listRxy;
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'questionnaireId' => 'required'
        ]);

        $student = Auth::user()->student;
        $questionnaire = Questionnaire::findOrFail($data['questionnaireId']);

        $submission = Submission::create([
            'questionnaire_id' => $questionnaire->id,
            'nim' => $student->nim
        ]);

        foreach ($request->all() as $questionId => $scale) {
            if (!str_starts_with($questionId, 'question-id-'))
                continue;
            $questionId = explode('question-id-', $questionId)[1];

            // dd($scale);
            Answer::create([
                'submission_id' => $submission->id,
                'question_id' => $questionId,
                'scale' => $scale
            ]);
        }

        return back();
    }
}
