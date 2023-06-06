<?php

namespace App\Tools;

use App\Http\Kernel;
use Cronitor;

class RequestTools
{
    public static function inputPost(string $key): mixed
    {
        return $_POST[$key] ?? null;
    }

    public static function inputPostAll(): array
    {
        return $_POST;
    }

    public static function inputGet(?string $key): mixed
    {
        return $_GET[$key] ?? null;
    }

    public static function isApplicationInDemoMode(): bool
    {
        return env('APP_DEMO_MODE', false);
    }

    public static function isApplicationInDevelopMode(): bool
    {
        return env('APP_ENV') != 'production';
    }

    public static function notifyCronjobStart(string $taskName): void
    {
        if (self::isApplicationInDevelopMode()) {
            return;
        }
        $client = new Cronitor\Client(config('services.cronitor.api_key'));
        $monitor = $client->monitor($taskName);
        $monitor->ping(['state' => 'run', 'message' => 'Cron started']);
    }

    public static function notifyCronjobDone(string $taskName): void
    {
        if (self::isApplicationInDevelopMode()) {
            return;
        }
        $client = new Cronitor\Client(config('services.cronitor.api_key'));
        $monitor = $client->monitor($taskName);
        $monitor->ping(['state' => 'complete', 'message' => 'Cron executed successfully']);
    }

    public static function notifyCronjobFailed(string $taskName, string $message): void
    {
        if (self::isApplicationInDevelopMode()) {
            return;
        }
        $client = new Cronitor\Client(config('services.cronitor.api_key'));
        $monitor = $client->monitor($taskName);
        $monitor->ping(['state' => 'fail', 'message' => $message]);
    }

    public static function startLaravelApp(): void
    {
        $app = require_once __DIR__ . '/../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
    }
}