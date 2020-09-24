<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/old-index', function () {
    return view('welcome');
});

Route::get('/test', function () {
  return 'check it out';
});
