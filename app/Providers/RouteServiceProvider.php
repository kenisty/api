<?php declare(strict_types=1);

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
        RateLimiter::for('api', static function (Request $request) {
            $user = $request->user();
            $limitBy = $user instanceof User ? $user->id : $request->ip();

            return Limit::perMinute(60)->by($limitBy);
        });

        $this->routes(static fn () => Route::middleware('api')->group(base_path('routes/v1/api.php')));
    }
}
