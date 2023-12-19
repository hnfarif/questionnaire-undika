<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        if ($request->has('questionnaireId')) {
            $questions = Question::where('questionnaire_id', '=', $request->questionnaireId)->get();
            return response()->json($questions);
        }

        $questions = Question::all();
        return response()->json($questions);
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
