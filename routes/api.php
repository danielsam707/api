<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\TagController;

use App\Http\Controllers\Api\LoginController;


/**
* Route::get('/user', function (Request $request) {
    * return $request->user();
* })->middleware('auth:sanctum');
 *
 * ESTA ES LA VERSION INDIVIDUAL DE LAS RUTAS
 * Route::get('recipes',               [RecipeController::class, 'index']); // Obtener todos los recursos (listar todas las recetas)
 * Route::post('recipes',              [RecipeController::class, 'store']); // Crear una nueva receta (almacenar una receta)
 * Route::get('recipes/{recipe}',      [RecipeController::class, 'show']); // Obtener un recurso específico (mostrar una receta por ID)
 * Route::put('recipes/{recipe}',      [RecipeController::class, 'update']); // Actualizar un recurso específico (modificar una receta por ID)
 * Route::delete('recipes/{recipe}',   [RecipeController::class, 'destroy']); // Eliminar un recurso específico (eliminar una receta por ID)
 *
 * EVOLUCION DE LAS RUTAS
 *
 * Route::get('categories',            [CategoryController::class, 'index']);
 * Route::get('categories/{category}', [CategoryController::class, 'show']);
 *
 * Route::apiResource('recipes',RecipeController::class);
 *
 *
 *
 * Route::get('tags',                  [TagController::class, 'index']);
 * Route::get('tags/{tag}',            [TagController::class, 'show']);
 */

Route::get('login', [LoginController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('categories',            [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    Route::apiResource('recipes',RecipeController::class);

    Route::get('tags',                  [TagController::class, 'index']);
    Route::get('tags/{tag}',            [TagController::class, 'show']);
});

