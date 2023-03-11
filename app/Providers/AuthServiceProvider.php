<?php

namespace App\Providers;

use App\Enums\ConfigEnum;
use App\Models\User;
use App\Services\ConfigurationService;
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
        Auth::viaRequest('mfp-token', function (Request $request) {
            $mfpToken = app(ConfigurationService::class)->findConfigValue(ConfigEnum::MFP_TOKEN);
            $requestToken = $request->header(ConfigEnum::MFP_TOKEN) ?? null;
            return ($mfpToken == $requestToken) ? new User() : null;
        });
    }
}
