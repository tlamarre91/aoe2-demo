<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CivilizationController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/initialize', function () {
  return 'TODO!';
});

Route::get('/civilizations', [CivilizationController::class, 'index']);
Route::get('/civilizations/{id}', [CivilizationController::class, 'show']);
