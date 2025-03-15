<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
	Route::prefix('login')->name('login')->group(function () {
		Route::get('', [AuthController::class, 'index']);
		Route::post('', [AuthController::class, 'attempt'])->name('.attempt');

		Route::prefix('forgot-password')->name('.forgot-password.')->group(function () {
			Route::get('', [ForgotPasswordController::class, 'index'])->name('index');
			Route::post('', [ForgotPasswordController::class, 'attempt'])->name('attempt');
		});
	});

	Route::prefix('reset-password')->name('reset-password.')->group(function () {
		Route::get('{token}', [ResetPasswordController::class, 'index'])->name('index');
		Route::post('', [ResetPasswordController::class, 'attempt'])->name('attempt');
	});

	Route::prefix('register')->name('register.')->group(function () {
		Route::get('', [RegisterController::class, 'index'])->name('index');
		Route::post('', [RegisterController::class, 'attempt'])->name('attempt');
	});
});

Route::middleware('auth:web')->group(function () {
	Route::get('/', function () {
		return view('welcome');
	})->name('index');
});


//Resource routes
Route::prefix('js')->name('assets.')->group(function () {
	Route::get('translations.js', [RouteController::class, 'translations'])->name('translations');
	Route::get('router.js', [RouteController::class, 'router'])->name('router');
});
