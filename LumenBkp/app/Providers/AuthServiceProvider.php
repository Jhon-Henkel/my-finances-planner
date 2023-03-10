<?php

namespace App\Providers;

use App\Providers\Passport\LumenPassport;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        LumenPassport::routes();
        LumenPassport::tokensExpireIn(Carbon::now()->addMinutes(60));
    }
}