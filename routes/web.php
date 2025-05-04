<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/test', function () {
    return Inertia ::render('Test');
})->name('test');



Route::get('/tictactoe', function () {
    return Inertia::render('Tictactoe');
})->name('tictactoe');



Route::get('/fruit', function () {
    return Inertia::render('Fruit');
})->name('fruit');

