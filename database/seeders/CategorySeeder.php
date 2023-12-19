<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryNames = ['Tangible', 'Reliability', 'Responsiveness', 'Empathy', 'Assurance'];
        foreach ($categoryNames as $categoryName) {
            Category::create(['name' => $categoryName]);
        }
    }
}
