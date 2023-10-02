<?php declare(strict_types=1);

use App\Http\Controllers\User\AuthControllerV1;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1/auth', 'controller' => AuthControllerV1::class], static function (): void {
    Route::post('register', 'register')->name('auth.register');
    Route::post('login', 'login')->name('auth.register');
});
