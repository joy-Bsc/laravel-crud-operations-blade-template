<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Simple SPA view that calls the REST API endpoints
Route::get('/', function () {
    return view('spa');
})->middleware(['auth', 'verified'])->name('home');

Route::get('dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

// Todo routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::apiResource('todos', TodoController::class);
    Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');
});

require __DIR__.'/settings.php';
