<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RecipeController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {

        $recipes = Recipe::orderBy('id', 'DESC')
            ->with('category', 'tags', 'user')
            ->paginate();
        return RecipeResource::collection($recipes);
    }

}
