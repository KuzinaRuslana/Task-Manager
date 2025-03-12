<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskStatusController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('task_statuses', TaskStatusController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('task_statuses', TaskStatusController::class)
    ->except(['create', 'edit', 'store', 'update', 'destroy']);

require __DIR__.'/auth.php';
