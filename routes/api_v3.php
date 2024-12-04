<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V3\ForeignController;


Route::prefix('v3')->group(function () {
    Route::get('recipes/dynamic_list', [ForeignController::class, 'showListDynamic']);
    Route::get('recipes', [ForeignController::class, 'showRecipes']);
    Route::get('recipes/categories', [ForeignController::class, 'showCategories']);
    Route::get('recipes/areas', [ForeignController::class, 'showAreas']);
    Route::get('recipes/ingredients', [ForeignController::class, 'showIngredients']);
});
