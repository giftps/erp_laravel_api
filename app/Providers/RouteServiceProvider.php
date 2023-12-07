<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware(['cors', 'api'])
                ->namespace($this->namespace)
                ->group(function($routes) {
                    require base_path('routes/api.php');
                    require base_path('routes/api/v1/lookups.php');
                    require base_path('routes/api/v1/sales.php');
                    require base_path('routes/api/v1/membership.php');
                    require base_path('routes/api/v1/user_access.php');
                    require base_path('routes/api/v1/users_and_administrations.php');
                    require base_path('routes/api/v1/non_staff.php');
                    require base_path('routes/api/v1/health_processing.php');
                    require base_path('routes/api/v1/preauthorisations.php');
                    require base_path('routes/api/v1/searches.php');
                    require base_path('routes/api/v1/administrations.php');
                    require base_path('routes/api/v1/app_member.php');
                    require base_path('routes/api/v1/financials_and_reports.php');
                    require base_path('routes/api/v1/claims.php');
                    require base_path('routes/api/v1/media.php');
                });
                
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
