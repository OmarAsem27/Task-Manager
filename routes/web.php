<?php

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/tasks', function () {
//     return view('tasks');
// });


Route::resource('tasks', TaskController::class);

Route::put('tasks/{task}/change-status', [TaskController::class, 'updateStatus'])->name('status');

Route::get('register', [RegistrationController::class, 'register']);
Route::post('register', [RegistrationController::class, 'store']);

Route::get('login', [SessionController::class, 'create']);
Route::post('login', [SessionController::class, 'store']);

Route::post('logout', [SessionController::class, 'destroy']);
