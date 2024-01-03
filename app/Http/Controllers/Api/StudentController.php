<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $students = Student::with(['studyProgram', 'user'])->get();
        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nim' => ['required', 'string', 'min:11', 'max:11'],
            'studyProgramId' => ['required', 'numeric'],
            'name' => ['required', 'min:4'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:4', 'max:32']
        ]);

        $student = DB::transaction(function () use ($data) {
            $user = User::create([
                'id' => $data['nim'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            $student = Student::create([
                'nim' => $user->id,
                'study_program_id' => $data['studyProgramId'],
                'name' => $data['name']
            ]);

            $role = Role::whereName("MAHASISWA")->first();
            $role->users()->attach($user->id);

            return $student->fresh();
        });

        return response()->json($student);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $student = Student::with(['studyProgram', 'user'])->findOrFail($id);
        return response()->json($student);
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
