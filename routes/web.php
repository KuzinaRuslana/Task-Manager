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

// Маршруты для статусов задач
Route::resource('task_statuses', TaskStatusController::class)
    ->middleware('auth');

// Маршруты для задач
Route::resource('tasks', TaskController::class)
    ->middleware('auth')
    ->except(['show']);

Route::get('/tasks/{task}', [TaskController::class, 'show'])
    ->name('tasks.show');

require __DIR__.'/auth.php';
