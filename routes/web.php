<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\LabelController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('task_statuses', TaskStatusController::class)
    ->only(['index']);

Route::middleware('auth')->group(function () {
    Route::resource('task_statuses', TaskStatusController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
    
    Route::resource('tasks', TaskController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('labels', LabelController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

Route::resource('tasks', TaskController::class)
    ->only(['index', 'show']);

Route::resource('labels', LabelController::class)
    ->only(['index']);

require __DIR__.'/auth.php';
