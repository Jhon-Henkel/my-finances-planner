<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            'App\Repositories\ExampleContractModel',
            'App\Repositories\ExampleModel'
        );
    }
}
