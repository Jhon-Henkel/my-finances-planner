<?php

namespace Tests\Feature\Modules\Auth\Controller\Login;

use App\Infra\Enum\RouteNameEnum;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\FeatureTestCase;

class AuthExpirationFeatureTest extends FeatureTestCase
{
    #[TestDox("Verificando que o token expira após 4 horas")]
    public function test()
    {
        $this->assertEquals(240, Config::get('session.lifetime'));
        $this->assertEquals(240, Config::get('sanctum.expiration'));

        $response = $this->postJson(route(RouteNameEnum::ApiV3AuthLogin), [
            'email' => $this->userMasterEmail,
            'password' => $this->userPassword,
        ])->assertJsonStructure([
            'status',
            'data' => ['token']
        ]);

        $headers = [
            'Authorization' => "Bearer {$response->json('data.token')}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->getJson(route(RouteNameEnum::ApiV3WalletList), $headers)->assertOk();

        $this->travel(3)->hours();
        $this->travel(59)->minutes();

        $this->getJson(route(RouteNameEnum::ApiV3WalletList), $headers)->assertOk();

        $this->travel(2)->minutes();

        $this->getJson(route(RouteNameEnum::ApiV3WalletList), $headers)->assertUnauthorized();
    }
}
