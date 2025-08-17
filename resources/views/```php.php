```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// ...existing routes...

Route::get('/register', [UserController::class, 'showRegister']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::post('/users/update/{id}', [UserController::class, 'update']);
Route::post('/users/delete/{id}', [UserController::class, 'destroy']);
Route::get('/users/search', [UserController::class, 'search']);
Route::get('/users/edit-all', [UserController::class, 'editAll']);
Route::post('/users/update-all', [UserController::class, 'updateAll']);

// ...existing routes...
Route::post('/users/toggle/{id}', [UserController::class, 'toggleStatus']);