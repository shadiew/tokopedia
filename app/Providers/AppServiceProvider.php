<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register admin middleware
        $this->app['router']->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cart count to all views
        view()->composer('*', function ($view) {
            $cartCount = 0;
            if (session()->has('cart')) {
                $cartCount = count(session('cart'));
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
