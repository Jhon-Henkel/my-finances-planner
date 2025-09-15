<?php

namespace App\Providers;

use App\Enums\ConfigEnum;
use App\Enums\StatusEnum;
use App\Exceptions\User\TryAlterAnotherUserByRequestException;
use App\Models\User;
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
            $mfpUserToken = $request->header(ConfigEnum::MfpUserTokenKey->value) ?? '';
            $userJWT = JwtTools::validateJWT($mfpUserToken);
            if (! $userJWT) {
                return null;
            }
            $mfpApiTokenEncrypted = bcrypt(config('app.mfp_token'));
            $mfpApiToken = $request->header(ConfigEnum::MfpTokenKey->value) ?? '';
            $isValidToken = password_verify($mfpApiToken, $mfpApiTokenEncrypted);
            $userDB = $this->getUserDB($userJWT->data->email);
            $this->validateIsAllowedRequest($userDB, $request);
            if ($isValidToken && $userDB->status === StatusEnum::Active->value) {
                return $userDB;
            }
            return null;
        });
    }

    protected function getUserDB(string $email): User|null
    {
        return User::query()->where('email', $email)->first();
    }

    protected function validateIsAllowedRequest(User $user, Request $request): void
    {
        if (is_object($request->route()) && $request->route()->uri() === 'api/user/{id}') {
            TryAlterAnotherUserByRequestException::throwIfRequestUserIdDifferentUserJwt($user, $request);
        }
    }
}
