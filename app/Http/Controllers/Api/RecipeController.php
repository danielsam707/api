<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Http\Resources\RecipeResource;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;

use Illuminate\Http\Request;
use App\Policies\RecipePolicy;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // si esto no puedo usar la policy

class RecipeController extends Controller
{
    use AuthorizesRequests; // si esto no puedo usar la policy
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

    public function store(StoreRecipeRequest $request)
    {

        //Se va a hacer un sistema de asignacion masiva
        $recipe = $request->user()->recipes()->create($request->all()); // Se agrego el llamado a la relacion
        $recipe->tags()->attach(json_decode($request->tags)); // Se corrigio


        //Retorno la respuesta a la aplicacion principal y tambine el mensaje
        return response()->json(new RecipeResource($recipe),Response::HTTP_CREATED); //HTTP 201
    }

    public function show(Recipe $recipe)
    {
        $recipe = $recipe->load('category', 'tags', 'user');
        return new RecipeResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);
        $recipe->update($request->all());

        if ($tags = json_decode($request->tags))
        {
            $recipe->tags()->sync($tags);
        }

        //Retorno la respuesta a la aplicacion principal y tambine el mensaje
        return response()->json(new RecipeResource($recipe),Response::HTTP_OK); //HTTP 200
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);
        $recipe->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);//204
    }
}
