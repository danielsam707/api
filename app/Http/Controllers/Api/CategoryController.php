<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function show(Category $category)
    {
        // Carga la categoria pero con todas las recetas y se debe hacer la relacion en el modelo Category.
        /**
         * Normalmente se utliza with en vez de load, pero el with se utiliza cuando la consulta es
         * desde cero, en este caso ya hay una consulta anterior que me arrojo el valor de $category
         */
        return $category->load('recipes');
    }
}
