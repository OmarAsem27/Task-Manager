<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthJWTController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthJWTController::class, 'register'])->name('register');
    Route::post('/login', [AuthJWTController::class, 'login'])->name('login');
    Route::post('/logout', [AuthJWTController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthJWTController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthJWTController::class, 'me'])->middleware('auth:api')->name('me');
});
