<?php

namespace App\Providers;

use App\Enums\ConfigEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Services\Database\DatabaseConnectionService;
use App\Tools\AppTools;
use App\Tools\Auth\JwtTools;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        Auth::viaRequest(ConfigEnum::MfpTokenKey->value, function (Request $request) {
            $dbConnection = new DatabaseConnectionService();
            $dbConnection->setMasterConnection();
            $mfpUserToken = $request->header(ConfigEnum::MfpUserTokenKey->value) ?? '';
            $user = JwtTools::validateJWT($mfpUserToken);
            if (! $user) {
                return null;
            }
            $mfpApiTokenEncrypted = bcrypt(AppTools::getEnvValue('PUSHER_APP_KEY'));
            $mfpApiToken = $request->header(ConfigEnum::MfpTokenKey->value) ?? '';
            $isValidToken = password_verify($mfpApiToken, $mfpApiTokenEncrypted);
            $userDB = User::query()->where('email', $user->data->email)->first();
            if ($isValidToken && $userDB->status === StatusEnum::Active->value) {
                $dbConnection->connectUser($userDB);
                return new User((array)$user->data);
            }
            return null;
        });
    }
}
