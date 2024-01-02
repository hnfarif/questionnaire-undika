<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Answer::query()->with(['question', 'submission']);

        if ($request->has('questionnaireId')) {
            $query->whereHas('submission', function ($subQuery) use ($request) {
                $subQuery->where('questionnaire_id', $request->questionnaireId);
            });
        }

        if ($request->has('questionId')) {
            $query->where('question_id', $request->questionId);
        }

        if ($request->has('categoryId')) {
            $query->whereHas('question', function ($subQuery) use ($request) {
                $subQuery->where('category_id', $request->categoryId);
            });
        }

        $answers = $query->get();

        return response()->json($answers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $answer = Answer::findOrFail($id);

        return response()->json($answer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
