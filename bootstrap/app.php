<?php

use App\Console\Kernel as ConsoleKernel;
use App\Infra\Exceptions\Handler;
use App\Infra\Kernel as InfraKernel;
use Illuminate\Foundation\Application;

$app = new Application($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__));
$app->singleton(Illuminate\Contracts\Http\Kernel::class, InfraKernel::class);
$app->singleton(Illuminate\Contracts\Console\Kernel::class, ConsoleKernel::class);
$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, Handler::class);

return $app;
