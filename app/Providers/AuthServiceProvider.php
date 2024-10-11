<?php

namespace App\Providers;

use App\Enums\Cache\CacheKeyEnum;
use App\Enums\ConfigEnum;
use App\Enums\StatusEnum;
use App\Exceptions\User\TryAlterAnotherUserByRequestException;
use App\Models\CreditCard;
use App\Models\User;
use App\Models\WalletModel;
use App\Policies\CreditCardPolicy;
use App\Policies\FinancialHealthPolicy;
use App\Policies\WalletPolicy;
use App\Services\Database\DatabaseConnectionService;
use App\Tools\Auth\JwtTools;
use App\Tools\Cache\MfpCacheManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        WalletModel::class => WalletPolicy::class,
        CreditCard::class => CreditCardPolicy::class,
        'financial-health' => FinancialHealthPolicy::class,
    ];

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
            $mfpApiTokenEncrypted = bcrypt(config('app.mfp_token'));
            $mfpApiToken = $request->header(ConfigEnum::MfpTokenKey->value) ?? '';
            $isValidToken = password_verify($mfpApiToken, $mfpApiTokenEncrypted);
            $userDB = $this->getUserDB($userJWT->data->email);
            $this->validateIsAllowedRequest($userDB, $request);
            if ($isValidToken && $userDB->status === StatusEnum::Active->value) {
                $dbConnection->connectUser($userDB);
                return $userDB;
            }
            return null;
        });
    }

    protected function getUserDB(string $email): Model|User|null
    {
        $user =  MfpCacheManager::getModel($email, CacheKeyEnum::User);
        if (!$user) {
            $user = User::query()->where('email', $email)->first();
            MfpCacheManager::setModel($email, CacheKeyEnum::User, $user);
        }
        return $user;
    }

    protected function validateIsAllowedRequest(User $user, Request $request): void
    {
        if (is_object($request->route()) && $request->route()->uri() === 'api/user/{id}') {
            TryAlterAnotherUserByRequestException::throwIfRequestUserIdDifferentUserJwt($user, $request);
        }
    }
}
