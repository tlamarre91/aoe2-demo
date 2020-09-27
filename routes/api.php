<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CivilizationController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('civilizations/initialize', [CivilizationController::class, 'initialize']);
Route::post('civilizations/initialize-from-local', [CivilizationController::class, 'initializeFromLocal']);
Route::delete('civilizations/destroy-all', [CivilizationController::class, 'destroyAll']);
Route::resource('civilizations', CivilizationController::class);
