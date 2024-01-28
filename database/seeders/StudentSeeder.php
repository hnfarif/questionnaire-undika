<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stupro = StudyProgram::get();
        foreach ($stupro as $pro) {
            for ($i = 1; $i <= 30; $i++) {

                $user = User::create([
                    'id' => fake()->numerify('17#########'),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => Hash::make('123456'),
                    'remember_token' => Str::random(10),
                ]);

                $student = new Student([
                    'nim' => $user->id,
                    'study_program_id' => $pro->id,
                    'name' => fake()->name(),
                ]);

                $user->student()->save($student);

                $role = Role::whereName("MAHASISWA")->first();
                $role->users()->attach($user->id);
            }
        }

    }
}
