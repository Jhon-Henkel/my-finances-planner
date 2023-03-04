<?php

require_once __DIR__.'/../vendor/autoload.php';

use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionManager;
use Illuminate\Session\SessionServiceProvider;
use Laravel\Lumen\Bootstrap\LoadEnvironmentVariables;
use Laravel\Lumen\Application;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;
use Illuminate\Contracts\Console\Kernel as KernelContract;
use App\Console\Kernel;
use App\Http\Middleware\Authenticate;
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Mail\Mailer;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Contracts\Mail\MailQueue;

(new LoadEnvironmentVariables(dirname(__DIR__)))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Application(dirname(__DIR__));
$app->withFacades();
$app->withEloquent();
$app->singleton(ExceptionHandler::class, Handler::class);
$app->singleton(KernelContract::class, Kernel::class);
$app->configure('app');
$app->configure('mail');
$app->configure('session');
$app->routeMiddleware(['auth' => Authenticate::class,]);
$app->middleware([StartSession::class]);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(AppServiceProvider::class);
$app->register(AuthServiceProvider::class);
$app->register(MailServiceProvider::class);
$app->register(SessionServiceProvider::class);
$app->alias('mailer', Mailer::class);
$app->alias('mailer', MailerContract::class);
$app->alias('mailer', MailQueue::class);
$app->bind(SessionManager::class, function ($app) {
    return $app->make('session');
});
$app->router->group(['namespace' => 'App\Http\Controllers'], function ($router) {
    require __DIR__ . '/../routes/web.php';
});
return $app;