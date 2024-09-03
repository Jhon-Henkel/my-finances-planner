<?php

namespace App\Providers;

use App\Enums\ConfigEnum;
use App\Enums\StatusEnum;
use App\Exceptions\User\TryAlterAnotherUserByRequestException;
use App\Models\User;
use App\Services\Database\DatabaseConnectionService;
use App\Tools\AppTools;
use App\Tools\Auth\JwtTools;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        Auth::viaRequest(ConfigEnum::MfpTokenKey->value, function (Request $request) {
            $dbConnection = new DatabaseConnectionService();
            $dbConnection->setMasterConnection();
            $mfpUserToken = $request->header(ConfigEnum::MfpUserTokenKey->value) ?? '';
            $userJWT = JwtTools::validateJWT($mfpUserToken);
            if (! $userJWT) {
                return null;
            }
            $mfpApiTokenEncrypted = bcrypt(AppTools::getEnvValue('PUSHER_APP_KEY'));
            $mfpApiToken = $request->header(ConfigEnum::MfpTokenKey->value) ?? '';
            $isValidToken = password_verify($mfpApiToken, $mfpApiTokenEncrypted);
            $userDB = User::query()->where('email', $userJWT->data->email)->first();
            $this->validateIsAllowedRequest($userDB, $request);
            if ($isValidToken && $userDB->status === StatusEnum::Active->value) {
                $dbConnection->connectUser($userDB);
                return $userDB;
            }
            return null;
        });
    }

    protected function validateIsAllowedRequest(User $user, Request $request): void
    {
        if (is_object($request->route()) && $request->route()->uri() === 'api/user/{id}') {
            TryAlterAnotherUserByRequestException::throwIfRequestUserIdDifferentUserJwt($user, $request);
        }
    }
}
