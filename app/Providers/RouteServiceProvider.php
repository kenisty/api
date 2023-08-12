<?php

namespace App\Providers;

use App\Models\User\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            $user = $request->user();

            if (!$user instanceof User) {
                return Limit::perMinute(60)->by($request->ip());
            }

            return Limit::perMinute(60)->by($user->id);
        });

        $this->routes(fn () => Route::middleware('api')->group(base_path('routes/api.php')));
    }
}
