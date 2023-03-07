<?php

namespace App\Providers;

use App\Enums\ConfigEnum;
use App\Models\UserModel;
use App\Services\ConfigService;
use Illuminate\Support\Facades\Auth;
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
        // todo validar, está funcionando a autenticação de usuário mas não a de api
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->header(ConfigEnum::MFP_TOKEN) ?? '';
            if ($this->isValidToken($token)) {
                return new UserModel();
            }
            return null;
        });
        $this->app['auth']->viaRequest('/', function ($request) {
            if (UserModel::isUserLogged()) {
                return new UserModel();
            }
            return null;
        });
    }

    protected function isValidToken(string $token): bool
    {
        $configService = app(ConfigService::class);
        return $token === $configService->getConfigValue(ConfigEnum::MFP_TOKEN);
    }
}