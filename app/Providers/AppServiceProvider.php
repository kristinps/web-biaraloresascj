<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Compute when view is composed so the route is already resolved (boot can run before route match)
        View::composer('admin.*', function ($view) {
            $view->with('routePrefix', request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
            $view->with('userRoutePrefix', request()->routeIs('dashboard.*') ? 'dashboard.user' : 'user');
        });
        View::composer('user.*', function ($view) {
            $view->with('userRoutePrefix', request()->routeIs('dashboard.*') ? 'dashboard.user' : 'user');
        });
    }
}
