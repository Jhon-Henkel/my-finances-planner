<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            'App\Repositories\BasicRepositoryContract',
            'App\Repositories\BasicRepository'
        );
        $this->app->bind(
            'App\Http\BasicControllerContract',
            'App\Http\BasicController'
        );
        $this->app->bind(
            'App\Resources\BasicControllerContract',
            'App\Resources\BasicController'
        );
        $this->app->bind(
            'App\Services\BasicServiceContract',
            'App\Services\BasicService'
        );
    }
}