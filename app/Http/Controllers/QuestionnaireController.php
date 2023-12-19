<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view("questionnaire.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $categories = Category::all();
        return view("questionnaire.detail", compact("questionnaire", "categories"));
    }
}
