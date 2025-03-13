<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
	Route::prefix('login')->name('login')->group(function () {
		Route::get('', [AuthController::class, 'index']);
		Route::post('', [AuthController::class, 'attempt'])->name('.attempt');

		Route::prefix('reset-password')->name('.forgot-password.')->group(function () {
			Route::get('', [ForgotPasswordController::class, 'index'])->name('index');
			Route::post('', [ForgotPasswordController::class, 'attempt'])->name('attempt');
		});
	});

	Route::prefix('register')->name('register.')->group(function () {
		Route::get('', [RegisterController::class, 'index'])->name('index');
		Route::post('', [RegisterController::class, 'register'])->name('register');
	});
});

Route::middleware('auth:web')->group(function () {
	Route::get('/', function () {
		return view('welcome');
	});
});