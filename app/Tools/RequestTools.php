<?php

namespace App\Tools;

use App\Http\Kernel;
use Sentry\CheckIn;
use Sentry\CheckInStatus;
use Sentry\Event;
use Sentry\SentrySdk;

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

    public static function notifyCronjobStart(string $name): CheckIn
    {
        $event = Event::createCheckIn();
        $checkIn = new CheckIn(
            monitorSlug: $name,
            status: CheckInStatus::inProgress(),
        );
        $event->setCheckIn($checkIn);
        SentrySdk::getCurrentHub()->captureEvent($event);
        return $checkIn;
    }

    public static function notifyCronjobDone(CheckIn $checkIn, string $name): void
    {
        $event = Event::createCheckIn();
        $event->setCheckIn(new CheckIn(
            monitorSlug: $name,
            status: CheckInStatus::ok(),
            id: $checkIn->getId(),
        ));
        SentrySdk::getCurrentHub()->captureEvent($event);
    }

    public static function notifyCronjobFailed(CheckIn $checkIn, string $name): void
    {
        $event = Event::createCheckIn();
        $event->setCheckIn(new CheckIn(
            monitorSlug: $name,
            status: CheckInStatus::error(),
            id: $checkIn->getId(),
        ));
        SentrySdk::getCurrentHub()->captureEvent($event);
    }

    public static function startLaravelApp(): void
    {
        $app = require_once __DIR__.'/../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
    }
}