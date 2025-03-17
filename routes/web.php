<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('task_statuses', TaskStatusController::class)
    ->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::resource('task_statuses', TaskStatusController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

Route::resource('tasks', TaskController::class)
    ->only(['index', 'show']);

Route::resource('tasks', TaskController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

require __DIR__.'/auth.php';
