<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index()
    {
        //return CategoryResource::collection(Category::all()); esta seria la manera si no hubiera un CategoryColletion
        return new CategoryCollection(Category::all());

    }

    public function show(Category $category)
    {
        $category = $category->load('recipes');
        return new CategoryResource($category);
    }
}
