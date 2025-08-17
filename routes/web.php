<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HelloController;

// specific routes (must come before any catch-all)
Route::get('/register', [UserController::class, 'showRegister']);
Route::post('/register', [UserController::class, 'store']);

Route::get('/', function () {
    return redirect('/register');
});

// user actions used by the view
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::post('/users/update/{id}', [UserController::class, 'update']);
Route::post('/users/delete/{id}', [UserController::class, 'destroy']);
Route::get('/users/search', [UserController::class, 'search']);
Route::get('/users/edit-all', [UserController::class, 'editAll']);
Route::post('/users/update-all', [UserController::class, 'updateAll']);
Route::post('/users/toggle/{id}', [UserController::class, 'toggleStatus']);

// catch-all (restricted to numbers) — keep last
Route::get('/{age}', [HelloController::class, 'index'])->where('age', '[0-9]+');

