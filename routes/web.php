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


Route::get('/product-manager', function () {
    $p = Product::all();
    return Inertia::render('ProductManager', compact('p'));
})->name('product-manager');

Route::get('/product/create', function () {
    return Inertia::render('ProductForm');
})->name('product.create');

Route::get('/product/{id}/edit', function ($id) {
    $product = Product::findOrFail($id);
    return Inertia::render('ProductForm', compact('product'));
})->name('product.edit');




// routes/web.php
// use App\Models\Product;
Route::get('/product', function () {
    $products = Product::all();
    return Inertia::render('ProductList', compact('products') );
})->name('product');



use App\Http\Controllers\EmployeeController;

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');


```php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/employees', function () {
        return Inertia::render('Employees/Index', [
            'employees' => \App\Models\Employee::paginate(10),
        ]);
    })->name('employees.index');
});


use Inertia\Inertia;
use App\Models\Employee;

Route::middleware('auth')->group(function () {
    Route::get('/employees/create', function () {
        return Inertia::render('Employees/CreateEdit');
    })->name('employees.create');

    Route::get('/employees/{employee}/edit', function (Employee $employee) {
        return Inertia::render('Employees/CreateEdit', [
            'employee' => $employee,
        ]);
    })->name('employees.edit');
});
