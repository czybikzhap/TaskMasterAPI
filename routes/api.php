<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;


Route::get('/tasks/status/{status}', [TaskController::class, 'getByStatus'])
    ->where('status', 'pending|in_progress|completed')
    ->name('tasks.by-status');

Route::apiResource('tasks', TaskController::class);
