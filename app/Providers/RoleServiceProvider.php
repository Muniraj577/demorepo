<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::if('hasRole', function (string $role){
            if (getUser()->hasRole($role)){
                return true;
            }
            return false;
        });

        Blade::if('hasAnyRoles', function (array $roles){
            $user = getUser();
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return true;
                }
            }
            return false;
        });
    }
}
