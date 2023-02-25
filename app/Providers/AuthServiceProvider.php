<?php

namespace App\Providers;

use App\Models\User;
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
        //todo implementar token armazenado no banco do banco e alterar o header do token
        $this->app['auth']->viaRequest('api', function ($request) {
            $header = $request->header('Api-Token') ?? '';
            if ($header === 'testeToken') {
//                Nesse return ele traz o usuário que tem salvo no db com o token informado
//                return User::where('api_token', $request->input('api_token'))->first();
                return new User();
            }
            return null;
        });
    }
}
