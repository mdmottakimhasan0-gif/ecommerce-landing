<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (
            app()->environment('production') ||
            request()->header('x-forwarded-proto') === 'https' ||
            request()->server('HTTP_X_FORWARDED_PROTO') === 'https' ||
            isset($_SERVER['RENDER']) ||
            str_contains(request()->getHost(), 'onrender.com') ||
            str_contains(request()->getHost(), 'railway.app')
        ) {
            URL::forceScheme('https');
        }
    }
}
