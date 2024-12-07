<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Other register logic if needed...
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Custom Middleware
        $this->app['router']->aliasMiddleware('generate_wallet', \App\Http\Middleware\GenerateWallet::class);
    }
}
