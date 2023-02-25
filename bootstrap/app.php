<?php

require_once __DIR__.'/../vendor/autoload.php';

use Laravel\Lumen\Bootstrap\LoadEnvironmentVariables;
use Laravel\Lumen\Application;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;
use Illuminate\Contracts\Console\Kernel as KernelContract;
use App\Console\Kernel;
use App\Http\Middleware\Authenticate;
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;

(new LoadEnvironmentVariables(dirname(__DIR__)))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Application(dirname(__DIR__));
$app->withFacades();
$app->withEloquent();
$app->singleton(ExceptionHandler::class, Handler::class);
$app->singleton(KernelContract::class, Kernel::class);
$app->configure('app');
// $app->middleware([App\Http\Middleware\ExampleMiddleware::class]);
$app->routeMiddleware(['auth' => Authenticate::class,]);
$app->register(AppServiceProvider::class);
$app->register(AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->router->group(
    ['namespace' => 'App\Http\Controllers'],
    function ($router) {
        require __DIR__ . '/../routes/web.php';
    }
);
return $app;
