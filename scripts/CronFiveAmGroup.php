<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CronService;
use Illuminate\Contracts\Console\Kernel;

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

try {
    $service = app(CronService::class);
    if (! $service->truncateDatabaseDemoTables()) {
        die('Error: Not in demo mode or error truncating tables');
    }
    if (! $service->insertDatabaseDemoData()) {
        die('Error: Not in demo mode or error inserting data');
    }
    echo 'Cron executed successfully';
} catch (Throwable $exception) {
    echo $exception->getMessage();
}