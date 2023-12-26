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

        $rxy = [];
        $r = $this->getR($submissions, $categories, $questions);

        return view('submission.index', compact('submissions', 'questions', 'categories', 'rxy', 'r'));
    }

    private function getRxy($questions, $submissions)
    {
        $listRxy = [];
        $n = $submissions->count(); //benar

        $dns = [];

        foreach ($questions as $question) {
            $yi = 0;
            $sumxi = 0; // benar
            $sumyi = 0; //benar
            $sumxi = 0; // benar
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
            $sumxi = $answers->sum('scale');

            foreach ($answers as $answer) {
                $yi = Answer::query()
                    ->with(['question', 'submission'])
                    ->whereHas('question', function ($subQuery) use ($answer) {
                        $subQuery->where('category_id', $answer->question->category_id);
                    })
                    ->whereHas('submission', function ($subQuery) use ($answer) {
                        $subQuery->where('nim', $answer->submission->nim)
                            ->where('id', $answer->submission->id);
                    })
                    ->sum('scale');


                $sumyi += $yi;
                $sumyi2 += pow($yi, 2);
                $sumxiyi += $sumyi * $answer->scale;
                $sumxi2 += pow($answer->scale, 2);
            }


            $powsumxi = pow($sumxi, 2);
            $powsumyi = pow($sumyi, 2);
            $numerator = $n * $sumxiyi - ($sumxi * $sumyi);
            $denominator = ($n * $sumxi2 - $powsumxi) * ($n * $sumyi2 - $powsumyi);
            $rxy = $numerator / $denominator;
            array_push($dns, "$rxy = $numerator / $denominator => $n * $sumxiyi - ($sumxi * $sumyi) / ($n * $sumxi2 - $powsumxi) * ($n * $sumyi2 - $powsumyi)");
            $listRxy[$question->id] = $rxy;
            // return $denominator;
        }

        return $listRxy;
    }

    private function getR($submissions, $categories, $questions)
    {
        $n = $submissions->count();
        $listR = [];

        foreach ($categories as $category) {
            $k = $questions->where('category_id', $category->id)->count();
            $sumvariants = 0;
            $sumscale = 0;
            $sumscale2 = 0;

            foreach ($questions as $question) {
                $sumxi = 0;
                $sumxi2 = 0;

                if ($question->category_id === $category->id) {
                    $answers = Answer::query()->where('question_id', $question->id)->get();
                    foreach ($answers as $answer) {
                        $sumxi += $answer->scale;
                        $sumxi2 += pow($answer->scale, 2);
                        $sumscale += $answer->scale;
                        $sumscale2 += pow($answer->scale, 2);
                    }
                }

                $variant = ($sumxi2 - pow($sumxi, 2) / $n) / $n;
                $sumvariants += $variant;
            }

            $i13 = ($sumscale2 - (pow($sumscale, 2) / $k)) / $k;

            $listR[$category->id] = ($k / ($k - 1)) * (1 - ($sumvariants / $i13));
        }

        return $listR;
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
