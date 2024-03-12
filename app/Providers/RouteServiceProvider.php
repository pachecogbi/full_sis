<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    protected $namespace = 'App\\Http\\Controllers';
    protected $namespaceAuth = 'App\\Http\\Controllers\\Auth';

    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->loadRouteList();
    }

    private function loadRouteList()
    {
        $this->routes(
            function () {
                Route::namespace($this->namespaceAuth)->group(base_path('routes/auth.php'));
            }
        );
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for(
            'api',
            fn (Request $request) => Limit::perMinute(400)
        );
    }
}
