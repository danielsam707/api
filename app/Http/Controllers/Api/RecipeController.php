<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {

        /**
         * En este caso como si se crea una consulta desde cero si se puede trabajar con with
         * pero no se trabaja con el metodo all() se trabaja con un metodo mas flexible que
         * es get. Ya que al() trae toda la informacion.
         */
        return Recipe::with('category', 'tags', 'user')->get();
    }

    public function show(Recipe $recipe)
    {
        return $recipe->load('category', 'tags', 'user');
    }
}
