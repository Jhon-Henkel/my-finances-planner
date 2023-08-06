<?php

namespace App\Providers;

use App\Enums\ConfigEnum;
use App\Models\User;
use App\Tools\Auth\JwtTools;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        Auth::viaRequest(ConfigEnum::MFP_TOKEN, function (Request $request) {
            $mfpUserToken = $request->header(ConfigEnum::MFP_USER_TOKEN) ?? '';
            $user = JwtTools::validateJWT($mfpUserToken);
            if (! $user) {
                return null;
            }
            $mfpApiTokenEncrypted = bcrypt(env('PUSHER_APP_KEY'));
            $mfpApiToken = $request->header(ConfigEnum::MFP_TOKEN) ?? '';
            $isValidToken = password_verify($mfpApiToken, $mfpApiTokenEncrypted);
            $userDB = User::query()->where('email', $user->data->email)->first()->toArray();
            if ($isValidToken && $userDB['status'] === ConfigEnum::STATUS_ACTIVE) {
                return new User((array)$user->data);
            }
            return null;
        });
    }
}
