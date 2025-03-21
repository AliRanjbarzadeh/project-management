<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

//Datatables
Route::macro('datatable', function (string $controller) {
	Route::post("datatables", [$controller, 'datatables'])->name('datatables');
});

Route::middleware('guest')->group(function () {
	Route::prefix('login')->name('login')->group(function () {
		//Login routes
		Route::get('', [AuthController::class, 'index']);
		Route::post('', [AuthController::class, 'attempt'])->name('.attempt');

		//Forgot password routes
		Route::prefix('forgot-password')->name('.forgot-password.')->group(function () {
			Route::get('', [ForgotPasswordController::class, 'index'])->name('index');
			Route::post('', [ForgotPasswordController::class, 'attempt'])->name('attempt');
		});
	});

	//Reset password routes
	Route::prefix('reset-password')->name('reset-password.')->group(function () {
		Route::get('{token}', [ResetPasswordController::class, 'index'])->name('index');
		Route::post('', [ResetPasswordController::class, 'attempt'])->name('attempt');
	});

	//Register routes
	Route::prefix('register')->name('register.')->group(function () {
		Route::get('', [RegisterController::class, 'index'])->name('index');
		Route::post('', [RegisterController::class, 'attempt'])->name('attempt');
	});
});

Route::middleware('auth:web')->group(function () {
	//Logout
	Route::get('logout', [AuthController::class, 'logout'])->name('logout');

	//Profile routes
	Route::prefix('profile')->name('profile.')->group(function () {
		Route::get('', [ProfileController::class, 'index'])->name('index');
		Route::post('', [ProfileController::class, 'update'])->name('update');
	});

	//Dashboard
	Route::get('/', [DashboardController::class, 'index'])->name('index');

	//Project routes
	Route::prefix('projects')->name('projects.')->group(function () {
		Route::datatable(ProjectController::class);

		//Task routes
		Route::prefix('{project}/tasks')->name('tasks.')->group(function () {
			//Datatable
			Route::datatable(TaskController::class);

			//Change priority
			Route::patch('{task}/change-priority', [TaskController::class, 'changePriority'])->name('change-priority');

			//Change status
			Route::patch('{task}/change-status', [TaskController::class, 'changeStatus'])->name('change-status');
		});
		Route::resource('{project}/tasks', TaskController::class);
	});
	Route::resource('projects', ProjectController::class)->except('show');
});


//Resource routes
Route::prefix('js')->name('assets.')->group(function () {
	Route::get('translations.js', [RouteController::class, 'translations'])->name('translations');
	Route::get('router.js', [RouteController::class, 'router'])->name('router');
});
