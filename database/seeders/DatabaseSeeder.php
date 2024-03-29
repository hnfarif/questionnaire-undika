<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            EmployeeSeeder::class,
            FacultySeeder::class,
            StudyProgramSeeder::class,
            StudentSeeder::class,
            CategorySeeder::class,
            SemesterSeeder::class,
        ]);
    }
}
