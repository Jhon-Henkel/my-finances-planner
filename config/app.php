<?php

use Illuminate\Support\Facades\Facade;

return [
    'name' => env('APP_NAME', 'my_finances_planner'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'url_container_app' => env('APP_CONTAINER_URL'),
    'asset_url' => env('ASSET_URL', '/public'),
    'timezone' => 'America/Sao_Paulo',
    'locale' => 'en',
    'payment_method_name' => env('PAYMENT_METHOD_NAME'),
    'payment_method_client_id' => env('PAYMENT_METHOD_CLIENT_ID'),
    'payment_method_client_secret' => env('PAYMENT_METHOD_CLIENT_SECRET'),
    'payment_method_plan_id' => env('PAYMENT_METHOD_SUBSCRIBE_PLAN_ID'),
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => env('APP_KEY'),
    'mfp_token' => env('PUSHER_APP_KEY'),
    'queue_host' => env('QUEUE_HOST'),
    'queue_port' => env('QUEUE_PORT'),
    'queue_user' => env('QUEUE_USERNAME'),
    'queue_password' => env('QUEUE_PASSWORD'),
    'cipher' => 'AES-256-CBC',
    'mail_from_address' => env('MAIL_FROM_ADDRESS'),
    'mail_from_name' => env('MAIL_FROM_NAME'),
    'mail_master_address' => env('MAIL_MASTER_ADDRESS', ''),
    'max_wrong_login_attempts' => 5,
    'use_redis' => env('REDIS_ENABLED', false),
    'maintenance' => [
        'driver' => 'file',
    ],
    'providers' => [
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\TelescopeServiceProvider::class,

    ],

    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
    ])->toArray(),
];
