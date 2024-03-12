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

    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->loadRouteList();
    }

    private function loadRouteList()
    {
        $this->routes(
            function () {
                Route::namespace($this->namespace)->group(base_path('routes/integracao_clientes.php'));
                Route::namespace($this->namespace)->middleware('web')->group(base_path('routes/web.php'));
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
