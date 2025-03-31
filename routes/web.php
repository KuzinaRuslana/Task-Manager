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

Route::resource('task_statuses', TaskStatusController::class);
Route::resource('tasks', TaskController::class);
Route::resource('labels', LabelController::class);

require __DIR__ . '/auth.php';
