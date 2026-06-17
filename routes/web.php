<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('/tasks/trashed', [TaskController::class, 'trashed'])->name('tasks.trashed');

Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::post('/tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');

Route::delete('/tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');
