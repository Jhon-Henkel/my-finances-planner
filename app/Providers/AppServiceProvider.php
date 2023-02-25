<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            'App\DAO\TesteDaoContract',
            'App\DAO\TesteDAO'
        );
    }
}
