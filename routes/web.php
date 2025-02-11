<?php

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/tasks', function () {
//     return view('tasks');
// });

Route::prefix('{locale}')
    // ->middleware(['web', Localization::class])
    ->middleware(['web'])
    ->group(function () {
        Route::resource('tasks', TaskController::class);
        Route::get('tasks', [TaskController::class, 'index'])->name('home');
        Route::put('tasks/{task}/change-status', [TaskController::class, 'updateStatus'])->name('status');

        Route::get('register', [RegistrationController::class, 'register'])->name('web.register');
        Route::post('register', [RegistrationController::class, 'store']);

        Route::get('login', [SessionController::class, 'create'])->name('web.login');
        Route::post('login', [SessionController::class, 'store']);

        Route::post('logout', [SessionController::class, 'destroy'])->name('web.logout');
    });
