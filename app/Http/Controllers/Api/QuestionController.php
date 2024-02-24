<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $questions = [];
        if ($request->has('questionnaireId')) {
            $questions = Question::with('questionnaire')
                ->where('questionnaire_id', '=', $request->questionnaireId)
                ->get();
        } else {
            $questions = Question::all();
        }

        $this->calculateMean($questions);
        $this->calculateMedian($questions);
        $this->calculateMode($questions);
        $this->calculateVariance($questions);

        return response()->json($questions);
    }

    private function calculateMean($questions)
    {

        foreach ($questions as $question) {
            $answers = Answer::query()->where('question_id', $question->id)->get();
            $n = count($answers);

            if ($n === 0) {
                $question['mean'] = 0;
                return;
            } else {
                $sumOfScale = $answers->sum('scale');
                $question['mean'] = $sumOfScale / $n;
            }
        }
    }

    private function calculateMedian($questions)
    {
        foreach ($questions as $question) {
            $answers = Answer::query()->where('question_id', $question->id)->get()->pluck('scale')->sort()->toArray();
            $n = count($answers);

            if ($n === 0) {
                $question['median'] = 0;
            } else if ($n === 1) {
                $question['median'] = $answers[0];
            } else if ($n % 2 === 0) {
                // If the count is even, calculate the average of the middle two values
                $middle1 = $answers[$n / 2 - 1];
                $middle2 = $answers[$n / 2];
                $question['median'] = ($middle1 + $middle2) / 2;
            } else {
                // If the count is odd, pick the middle value
                $question['median'] = $answers[floor($n / 2)];
            }
        }
    }

    private function calculateMode($questions)
    {
        foreach ($questions as $question) {
            $answers = Answer::query()->where('question_id', $question->id)->get()->pluck('scale')->toArray();
            $frequency = array_count_values($answers);

            // Find the mode(s)
            if (count($answers) === 0) {
                $question['mode'] = 0;
            } else {
                $maxFrequency = max($frequency);
                $modes = array_keys($frequency, $maxFrequency);
                $question['mode'] = empty($modes) ? null : $modes[0]; // Assuming we take the first mode if there are multiple
            }
        }
    }

    private function calculateVariance($questions)
    {
        foreach ($questions as $question) {
            $answers = Answer::query()->where('question_id', $question->id)->get()->pluck('scale')->toArray();
            $mean = $question['mean'];

            $sumOfSquares = array_sum(array_map(function ($value) use ($mean) {
                return pow($value - $mean, 2);
            }, $answers));

            $n = count($answers);

            if ($n === 0) {
                $question['variance'] = 0;
            } else {
                try {
                    $question['variance'] = $sumOfSquares / ($n - 1);
                } catch (\Throwable $th) {
                    $question['variance'] = 0;
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'questionnaireId' => 'required',
            'categoryId' => 'required',
            'description' => 'string',
        ]);

        $questionnaire = Questionnaire::findOrFail($data['questionnaireId']);
        $category = Category::findOrFail($data['categoryId']);

        $question = Question::create([
            'questionnaire_id' => $questionnaire->id,
            'category_id' => $category->id,
            'description' => $data['description'],
        ]);

        return response()->json($question);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question): JsonResponse
    {
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question): JsonResponse
    {
        $data = $request->validate([
            'questionnaireId' => 'required',
            'categoryId' => 'required',
            'description' => 'string',
        ]);

        $question->questionnaire_id = $data['questionnaireId'];
        $question->category_id = $data['categoryId'];
        $question->description = $data['description'];
        $question->save();

        return response()->json($question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question): JsonResponse
    {
        $question->delete();
        return response()->json($question);
    }
}
