<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $meanPerCategory = $this->calculateMeanPerCategory();

        return response()->json($meanPerCategory);
    }

    private function calculateMeanPerCategory()
    {
        // Fetch all categories
        $categories = Category::all();

        // Loop through each category
        foreach ($categories as $category) {
            // Fetch questions belonging to the current category
            $questions = Question::where('category_id', $category->id)->get();

            // Initialize variables
            $totalScale = 0;
            $totalCount = 0;

            // Loop through questions to calculate total scale and count
            foreach ($questions as $question) {
                $answers = Answer::where('question_id', $question->id)->get();
                $totalScale += $answers->sum('scale');
                $totalCount += $answers->count();
            }

            // Calculate mean for the category
            $mean = ($totalCount > 0) ? $totalScale / $totalCount : 0;

            // Update category with the calculated mean
            $category->mean = $mean;
        }

        return $categories;
    }
}
