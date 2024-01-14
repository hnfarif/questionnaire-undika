<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Semester;
use App\Models\StudyProgram;
use App\Models\Submission;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {

        $studyProgramId = StudyProgram::whereMngrId(Auth::user()->id)->value("id");

        if ($request->has("studyProgramId")) {
            $studyProgramId = intval($request->get("studyProgramId"));
        }

        $semester = Semester::whereStudyProgramId($studyProgramId)->value("smt_active");

        if ($request->has("semester")) {

            $semester = $request->get("semester");
        }

        $questionnaires = Questionnaire::with('studyProgram')->whereStudyProgramId($studyProgramId)->semester($semester)->get();

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
        $semesterActive = Semester::whereStudyProgramId($studyProgramId)->first()->smt_active;

        $startDate = Carbon::parse($data['startDate']);
        $endDate = Carbon::parse($data['endDate'])->addDays(1);

        $overlapCheck = Questionnaire::where('study_program_id', $studyProgramId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $endDate);
                    });
            })
            ->exists();

        if ($overlapCheck) {
            throw new ErrorException('Overlap schedule');
        }


        $questionnaire = Questionnaire::create([
            'study_program_id' => $studyProgramId,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => 'DRAFT',
            'start_date' => $data['startDate'],
            'end_date' => $data['endDate'],
            'semester' => $semesterActive
        ]);

        return response()->json($questionnaire);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $questionnaire = Questionnaire::with('submissions', 'studyProgram.students')->findOrFail($id);

        $submissions = Submission::where('questionnaire_id', $questionnaire->id)
            ->with(['student', 'answers.question.category'])
            ->get();
        $questions = Question::where('questionnaire_id', $questionnaire->id)->get();
        $categories = Category::orderBy('id', 'asc')->get();

        $r = \App\Http\Controllers\SubmissionController::getR($submissions, $categories, $questions);
        $questionnaire['r'] = $r;

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

        $startDate = Carbon::parse($data['startDate']);
        $endDate = Carbon::parse($data['endDate'])->addDays(1);

        $overlapCheck = Questionnaire::where('study_program_id', $questionnaire->study_program_id)
            ->where('id', '!=', $questionnaire->id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<', $startDate)
                            ->where('end_date', '>', $endDate);
                    });
            })
            ->exists();

        if ($overlapCheck) {
            throw new ErrorException('Overlap schedule');
        }

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

    public function duplicateQuestionnaire($id): JsonResponse
    {
        $findQuestionnaire = Questionnaire::with('questions')->findOrFail($id);
        $semester = Semester::whereStudyProgramId($findQuestionnaire->study_program_id)->first();
        $duplicateQuestionnaire = Questionnaire::create(
            [
                'study_program_id' => $findQuestionnaire->study_program_id,
                'title' => $findQuestionnaire->title,
                'description' => $findQuestionnaire->description,
                'status' => 'DRAFT',
                'semester' => $semester->smt_active
            ]
        );

        foreach ($findQuestionnaire->questions as $question) {
            Question::create([
                'questionnaire_id' => $duplicateQuestionnaire->id,
                'category_id' => $question->category_id,
                'description' => $question->description,
            ]);
        }

        return response()->json($duplicateQuestionnaire);
    }
}
