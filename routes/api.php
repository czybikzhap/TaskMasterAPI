<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Additional task routes (должны быть ДО apiResource)
Route::get('/tasks/statistics', [TaskController::class, 'statistics'])
    ->name('tasks.statistics');

Route::get('/tasks/status/{status}', [TaskController::class, 'getByStatus'])
    ->where('status', 'pending|in_progress|completed')
    ->name('tasks.by-status');

// Task API routes
Route::apiResource('tasks', TaskController::class);
