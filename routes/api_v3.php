<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V3\ForeignController;


Route::prefix('v3')->group(function () {
    Route::get('foreign_recipes/categories', [ForeignController::class, 'index']);
    Route::get('foreign_recipes/name_id', [ForeignController::class, 'show']);
});
