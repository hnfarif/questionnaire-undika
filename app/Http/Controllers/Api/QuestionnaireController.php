<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\StudyProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $questionnaires = Questionnaire::all();
        return response()->json($questionnaires);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'startDate' => 'date',
            'endDate' => 'date',
        ]);

        $studyProgramId = StudyProgram::whereMngrId(Auth::user()->id)->first()->id;

        $questionnaire = Questionnaire::create([
            'study_program_id' => $studyProgramId,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => 'DRAFT',
            'start_date' => $data['startDate'],
            'end_date' => $data['endDate']
        ]);

        return response()->json($questionnaire);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        return response()->json($questionnaire);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'startDate' => 'date',
            'endDate' => 'date',
        ]);

        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->title = $data['title'];
        $questionnaire->description = $data['description'];
        $questionnaire->start_date = $data['startDate'];
        $questionnaire->end_date = $data['endDate'];
        $questionnaire->save();

        return response()->json($questionnaire);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->delete();
        return response()->json($questionnaire);
    }
}
