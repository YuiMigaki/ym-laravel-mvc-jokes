<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
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
    public function boot():void
    {
        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::before(function ($user) {
            if ($user->hasRole('Superuser')) {
                return true;
            }
            return null;
        });


        Gate::define('can delete superusers', function ($user) {
            return $user->hasRole('Superuser');
        });
        Gate::define('can delete admins', function ($user) {
            return $user->hasRole('Superuser');
        });

    }
}
