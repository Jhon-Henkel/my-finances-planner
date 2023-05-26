<?php

namespace App\Providers;

use App\Enums\ConfigEnum;
use App\Models\User;
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

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::viaRequest(ConfigEnum::MFP_TOKEN, function (Request $request) {
            $requestToken = $request->header(ConfigEnum::MFP_TOKEN) ?? null;
            if (is_null($requestToken)) {
                return null;
            }
            return (env('PUSHER_APP_KEY') == $requestToken) ? new User() : null;
        });
    }
}
