<?php

namespace App\Providers;

use App\Enums\ConfigEnum;
use App\Models\User;
use App\Services\ConfigService;
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
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->header(ConfigEnum::MFP_TOKEN) ?? '';
            if (!$this->isValidToken($token)) {
                return null;
            }
            return new User();
        });
    }

    protected function isValidToken(string $token): bool
    {
        $configService = app(ConfigService::class);
        return $token === $configService->getConfigValue(ConfigEnum::MFP_TOKEN);
    }
}