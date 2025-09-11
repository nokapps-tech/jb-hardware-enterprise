<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Grant all permissions to system administrator and developer accounts
        Gate::before(function ($user, $ability) {
            return $user->hasRole('system-administrator') || $user->hasRole('developer') ? true : null;
        });
    }
}
