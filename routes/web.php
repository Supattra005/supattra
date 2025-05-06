<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/test', function () {
    return Inertia::render('Test');
})->name('test');



Route::get('/tictactoe', function () {
    return Inertia::render('Tictactoe');
})->name('tictactoe');



Route::get('/fruit', function () {
    return Inertia::render('Fruit');
})->name('fruit');



Route::get('/hello-teacher', function () {
    return Inertia::render('HelloTeacher');
})->name('hello-teacher');



Route::get('/about-page', function () {
    return Inertia::render('AboutPage');
})->name('about-page');

Route::get('/home-page', function () {
    return Inertia::render('HomePage');
})->name('home-page');




Route::get('/bootstrap', function () {
    return Inertia::render('BootstrapContent');
})->name('bootstrap');




Route::get('/circle', function () {
    return Inertia::render('Circle');
})->name('circle');



Route::get('/counter', function () {
    return Inertia::render('Counter');
})->name('counter');



Route::get('/list-manager', function () {
    return Inertia::render('ListManager');
})->name('list-manager');


Route::get('/infinite-scroll', function () {
    return Inertia::render('InfiniteScrollExample');
})->name('infinite-scroll');