<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index()
    {
        //return CategoryResource::collection(Category::all()); esta seria la manera si no hubiera un CategoryColletion
        return new CategoryCollection(Category::all());

    }

    public function show(Category $category)
    {
        $category = $category->load('recipes.category', 'recipes.tags','recipes.user');
        return new CategoryResource($category);
    }
}
