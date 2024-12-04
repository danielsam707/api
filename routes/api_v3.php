<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V3\ForeignController;


Route::prefix('v3')->group(function () {
    Route::get('foreign_recipes', [ForeignController::class, 'index']);
});
