<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CivilizationController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('civilizations/initialize', [CivilizationController::class, 'initialize']);
Route::resource('civilizations', CivilizationController::class);
