<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');

// Update Status (Pending <-> Completed)
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');

// index, create, store, edit, update, destroy
Route::resource('tasks', TaskController::class)->except(['show']);