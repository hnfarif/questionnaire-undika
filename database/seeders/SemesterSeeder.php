<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studyPrograms = StudyProgram::all();

        foreach ($studyPrograms as $studyProgram) {
            Semester::create([
                "study_program_id" => $studyProgram->id,
                "smt_active" => "231",
                "smt_upcoming" => "232",
                "smt_previous" => "222"
            ]);
        }
    }
}
