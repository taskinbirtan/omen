<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/pots', function () {
    return view('pots');
});
Route::get('/fixtures', function () {
    return view('fixtures');
});
