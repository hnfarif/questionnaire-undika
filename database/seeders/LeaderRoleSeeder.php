<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LeaderRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {

            $user = User::create([
                'id' => fake()->randomNumber(6, true),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => Str::random(10),
            ]);

            $employee = new Employee([
                'nik' => $user->id,
                'name' => fake()->name(),
            ]);

            $user->employee()->save($employee);

            $role = Role::whereName("PIMPINAN")->first();
            $role->users()->attach($user->id);
        }
    }
}
