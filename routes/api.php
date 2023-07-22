<?php

use App\Http\Controllers\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/', fn() => view('welcome'))->name('index');
//Route::middleware('auth:sanctum')->get('/user', fn (Request $request) =>  $request->user());

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::post('register', 'register');
});
