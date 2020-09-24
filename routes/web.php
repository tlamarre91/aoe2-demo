<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\CivilizationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
  return 'check it out';
});

Route::get('/civilizations', [CivilizationController::class, 'index']);
Route::get('/civilizations/{id}', [CivilizationController::class, 'show']);
