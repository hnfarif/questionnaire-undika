<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Role;
use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $university = [
            'Teknologi dan Informatika' => [
                'S1 Sistem Informasi',
                'S1 Teknik Komputer',
                'DIII Sistem Informasi'
            ],
            'Ekonomi dan Bisnis' => ['S1 Manajemen', 'S1 Akuntansi'],
            'Desain dan Industri Kreatif' => [
                'S1 Desain Komunikasi Visual',
                'S1 Desain Produk',
                'DIV Produksi Film dan Televisi'
            ]
        ];

        $empStuPro = Role::whereName("KAPRODI")->first();
        $index = 0;

        foreach ($university as $facultyName => $studyPrograms) {
            foreach ($studyPrograms as $studyProgram) {
                $faculty = Faculty::whereName($facultyName)->first();
                StudyProgram::create([
                    'name' => $studyProgram,
                    'faculty_id' => $faculty->id,
                    'mngr_id' => $empStuPro->users()->get()[$index]->id
                ]);
                $index++;
            }
        }
    }
}
