<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faculties = [
            "Teknologi dan Informatika",
            "Ekonomi dan Bisnis",
            "Desain dan Industri Kreatif",
        ];

        $empFaculty = Role::whereName("FACULTY")->first();

        foreach ($faculties as $index => $fac) {

            Faculty::create([
                "name" => $fac,
                "mngr_id" => $empFaculty->users()->get()[$index]->id,
            ]);
        }
    }
}
