<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
	return response()->json(['message' => 'test']);
});

Route::middleware('auth.basic')->group(function () {
	//Projects routes
	Route::get('projects', [ProjectController::class, 'index']);

	//Task routes
	Route::get('tasks', [TaskController::class, 'index']);
	Route::post('tasks/store', [TaskController::class, 'store']);
	Route::put('tasks/{taskId}/complete', [TaskController::class, 'markAsCompleted']);
	Route::delete('tasks/{taskId}', [TaskController::class, 'destroy']);
});