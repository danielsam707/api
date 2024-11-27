<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Http\Resources\RecipeResource;


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
        $recipes = Recipe::with('category', 'tags', 'user')->get();
        return RecipeResource::collection($recipes);
    }

    public function store(Request $request)
    {

    }

    public function show(Recipe $recipe)
    {
        $recipe = $recipe->load('category', 'tags', 'user');
        return new RecipeResource($recipe);
    }

    public function update(Request $request, Recipe $recipe)
    {

    }

    public function destroy(Recipe $recipe)
    {

    }
}
