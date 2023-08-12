<?php

use App\Http\Controllers\User\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::post('register', 'register')->name('auth.register');
    Route::post('login',  'login')->name('auth.register');
});
