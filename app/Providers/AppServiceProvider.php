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
        View::share('routePrefix', request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
        View::share('userRoutePrefix', request()->routeIs('dashboard.*') ? 'dashboard.user' : 'user');
    }
}
