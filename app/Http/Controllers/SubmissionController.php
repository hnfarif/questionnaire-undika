<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Submission;
use DivisionByZeroError;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    private $rValues = [
        0.9969,
        0.9969,
        0.9969,
        0.9500,
        0.8783,
        0.8114,
        0.7545,
        0.7067,
        0.6664,
        0.6319,
        0.6021,
        0.5760,
        0.5529,
        0.5324,
        0.5140,
        0.4973,
        0.4821,
        0.4683,
        0.4555,
        0.4438,
        0.4329,
        0.4227,
        0.4132,
        0.4044,
        0.3961,
        0.3882,
        0.3809,
        0.3739,
        0.3673,
        0.3610,
        0.3550,
        0.3494,
        0.3440,
        0.3388,
        0.3338,
        0.3291,
        0.3246,
        0.3202,
        0.3160,
        0.3120,
        0.3081,
        0.3044,
        0.3008,
        0.2973,
        0.2940,
        0.2907,
        0.2876,
        0.2845,
        0.2816,
        0.2787,
        0.2759,
        0.2732,
        0.2706,
        0.2681,
        0.2656,
        0.2632,
        0.2609,
        0.2586,
        0.2564,
        0.2542,
        0.2521,
        0.2500,
        0.2480,
        0.2461,
        0.2441,
        0.2423,
        0.2404,
        0.2387,
        0.2369,
        0.2352,
        0.2335,
        0.2319,
        0.2303,
        0.2287,
        0.2272,
        0.2257,
        0.2242,
        0.2227,
        0.2213,
        0.2199,
        0.2185,
        0.2172,
        0.2159,
        0.2146,
        0.2133,
        0.2120,
        0.2108,
        0.2096,
        0.2084,
        0.2072,
        0.2061,
        0.2050,
        0.2039,
        0.2028,
        0.2017,
        0.2006,
        0.1996,
        0.1986,
        0.1975,
        0.1966,
        0.1956,
        0.1946,
        0.1937,
        0.1927,
        0.1918,
        0.1909,
        0.1900,
        0.1891,
        0.1882,
        0.1874,
        0.1865,
        0.1857,
        0.1848,
        0.1840,
        0.1832,
        0.1824,
        0.1816,
        0.1809,
        0.1801,
        0.1793,
        0.1786,
        0.1779,
        0.1771,
        0.1764,
        0.1757,
        0.1750,
        0.1743,
        0.1736,
        0.1729,
        0.1723,
        0.1716,
        0.1710,
        0.1703,
        0.1697,
        0.1690,
        0.1684,
        0.1678,
        0.1672,
        0.1666,
        0.1660,
        0.1654,
        0.1648,
        0.1642,
        0.1637,
        0.1631,
        0.1625,
        0.1620,
        0.1614,
        0.1609,
        0.1603,
        0.1598,
    ];

    public function index(Request $request): View
    {
        if (!$request->has('questionnaireId')) {
            abort(404);
        }

        try {
            $questionnaireId = $request->questionnaireId;
            $questionnaire = Questionnaire::findOrFail($questionnaireId);
            $submissions = Submission::where('questionnaire_id', $questionnaireId)
                ->with(['student', 'answers.question.category'])
                ->get();
            $questions = Question::where('questionnaire_id', $questionnaireId)->get();

            $rValue = 0;
            $numberOfSubmissions = count($submissions);
            if ($numberOfSubmissions > count($this->rValues)) {
                $rValue = $this->rValues[count($submissions) - 1];
            } else {
                $rValue = $this->rValues[$numberOfSubmissions - 1];
            }

            $categories = Category::orderBy('id', 'asc')->get();

            $rxy = self::getRxy($questions, $submissions);

            $r = self::getR($submissions, $categories, $questions);

            $this->calculateMean($questions);
        } catch (\Throwable $th) {
            abort(404);
        }

        return view('submission.index', compact('rValue', 'questionnaire', 'submissions', 'questions', 'categories', 'rxy', 'r'));
    }

    public static function getRxy($questions, $submissions): array
    {
        $listRxy = [];
        $n = $submissions->count();

        foreach ($questions as $question) {
            $sumyi = 0;
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
                $sumxiyi += $yi * $answer->scale;

                $sumxi2 += pow($answer->scale, 2);
            }


            $powsumxi = pow($sumxi, 2);
            $powsumyi = pow($sumyi, 2);
            $numerator = $n * $sumxiyi - ($sumxi * $sumyi);
            $denominator = sqrt(($n * $sumxi2 - $powsumxi) * ($n * $sumyi2 - $powsumyi));

            try {
                $rxy = $numerator / $denominator;
                $listRxy[$question->id] = $rxy;
            } catch (DivisionByZeroError) {
                $listRxy[$question->id] = 0;
            }
        }

        return $listRxy;
    }

    public static function getR($submissions, $categories, $questions): array
    {
        $n = $submissions->count();
        $listR = [];

        foreach ($categories as $category) {
            $k = $questions->where('category_id', $category->id)->count();
            $sumvariants = 0;

            foreach ($questions->where('category_id', $category->id) as $question) {
                $sumxi = 0;
                $sumxi2 = 0;

                $answers = Answer::query()->where('question_id', $question->id)->get();
                foreach ($answers as $answer) {
                    $sumxi += $answer->scale;
                    $sumxi2 += pow($answer->scale, 2);

                }

                $variant = 0;
                try {
                    $variant = ($sumxi2 - pow($sumxi, 2) / $n) / $n;
                } catch (DivisionByZeroError) {
                    $variant = 0;
                }
                $sumvariants += $variant;
            }


            $filteredSubmissions = [];
            foreach ($submissions as $submission) {
                $filteredAnswers = [];
                foreach ($submission->answers as $answer) {
                    if ($answer->question->category_id === $category->id) {
                        $filteredAnswers[] = clone $answer;
                    }
                }
                if (!empty($filteredAnswers)) {
                    $clonedSubmission = clone $submission;
                    $clonedSubmission->answers = $filteredAnswers;
                    $filteredSubmissions[] = $clonedSubmission;
                }
            }

            // dd($filteredSubmissions);

            $sumscale2 = 0;
            $sumOfSumScale2 = 0;
            foreach ($filteredSubmissions as $submission) {
                $sumscale = 0;
                foreach ($submission->answers as $answer) {
                    $sumscale += $answer->scale;
                }
                $sumOfSumScale2 += $sumscale;
                $sumscale2 += pow($sumscale, 2);
            }

            try {
                $i13 = ($sumscale2 - (pow($sumOfSumScale2, 2) / $n)) / $n;
                $listR[$category->id] = ($k / ($k - 1)) * (1 - ($sumvariants / $i13));
            } catch (DivisionByZeroError) {
                $listR[$category->id] = 0;
            }
        }

        return $listR;
    }

    private function calculateMean($questions): void
    {
        foreach ($questions as $question) {
            $query = Answer::where('question_id', $question->id);
            try {
                $question['mean'] = $query->sum('scale') / $query->count();
            } catch (DivisionByZeroError) {
                $question['mean'] = 0;
            }
        }
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
