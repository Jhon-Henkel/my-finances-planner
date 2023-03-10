<?php

namespace App\Providers\Passport;

use Illuminate\Database\Connection;
use Illuminate\Hashing\HashManager;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Laravel\Passport\PassportServiceProvider;

class LumenPassportServiceProvider extends PassportServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->singleton(Connection::class, function () {
            return $this->app['db.connection'];
        });
        $this->app->singleton(HashManager::class, function ($app) {
            return new HashManager($app);
        });
        if ($this->app->runningInConsole()) {
            $this->registerMigrations();
            $this->commands([
                InstallCommand::class,
                ClientCommand::class,
                KeysCommand::class,
            ]);
        }
    }

    /**
     * Setup the resource publishing groups for Passport.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/passport.php' => app('config')->get('passport.php'),
            ], 'passport-config');
        }
    }

}