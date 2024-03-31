<?php

namespace App\Providers;

use App\Contracts\ArtistInterface;
use App\Contracts\UserInterface;
use App\Repository\ArtistRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RespositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(ArtistInterface::class, ArtistRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
