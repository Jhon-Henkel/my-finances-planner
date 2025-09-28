<?php

namespace Tests\Feature\Modules\Auth\Controller\Login;

use App\Infra\Enum\RouteNameEnum;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Response\Enum\HttpStatusCodeEnum;
use App\Models\Log\AccessLog;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\FeatureTestCase;

class LoginControllerFeatureTest extends FeatureTestCase
{
    #[TestDox("Testando com credenciais válidas")]
    public function testRouteTestOne()
    {
        $this->postJson(route(RouteNameEnum::ApiV3AuthLogin), [
            'email' => $this->userMasterEmail,
            'password' => $this->userPassword,
        ])->assertOk()->assertJsonStructure(['status', 'data' => ['token']]);

        $this->assertDatabaseHas(AccessLog::class, [
            'user_id' => $this->masterUser->id,
        ]);
    }

    #[TestDox("Testando com credenciais inválidas")]
    public function testRouteTestTwo()
    {
        $response = $this->postJson(route(RouteNameEnum::ApiV3AuthLogin), [
            'email' => $this->userMasterEmail,
            'password' => 'P@s5w0rd',
        ])->assertUnauthorized()
            ->assertJsonStructure(['status', 'data']);

        $this->assertEquals('Login ou Senha inválidos', $response->json('data'));
        $this->assertEquals(1, $this->masterUser->refresh()->wrong_login_attempts);
    }

    #[TestDox("Testando com usuário inativo")]
    public function testRouteTestThree()
    {
        $this->masterUser->update(['status' => StatusActiveInactiveEnum::Inactive->value]);

        $response = $this->postJson(route(RouteNameEnum::ApiV3AuthLogin), [
            'email' => $this->userMasterEmail,
            'password' => $this->userPassword,
        ])->assertUnauthorized();

        $response->assertJson([
            'status' => HttpStatusCodeEnum::HttpUnauthorized->value,
            'data' => 'Usuário inativo'
        ]);
    }

    #[TestDox("Testando bloqueio de usuário por maximo de logins inválidos")]
    public function testRouteTestFour()
    {
        for ($i = 0; $i < config('app.max_wrong_login_attempts'); $i++) {
            $response = $this->postJson(route(RouteNameEnum::ApiV3AuthLogin), [
                'email' => $this->userMasterEmail,
                'password' => 'P@s5w0rd',
            ])->assertUnauthorized();

            $response->assertJson([
                'status' => HttpStatusCodeEnum::HttpUnauthorized->value,
                'data' => 'Login ou Senha inválidos'
            ]);

            $this->assertEquals($i + 1, $this->masterUser->refresh()->wrong_login_attempts);
        }

        $response = $this->postJson(route(RouteNameEnum::ApiV3AuthLogin), [
            'email' => $this->userMasterEmail,
            'password' => 'P@s5w0rd',
        ])->assertUnauthorized();

        $response->assertJson([
            'status' => HttpStatusCodeEnum::HttpUnauthorized->value,
            'data' => 'Usuário inativo'
        ]);
    }

    #[TestDox("Testando campo invalid_login_attempts após login válido")]
    public function testRouteTestFive()
    {
        for ($i = 0; $i < ((int)config('app.max_wrong_login_attempts') - 2); $i++) {
            $response = $this->postJson(route(RouteNameEnum::ApiV3AuthLogin), [
                'email' => $this->userMasterEmail,
                'password' => 'P@s5w0rd',
            ])->assertUnauthorized();

            $response->assertJson([
                'status' => HttpStatusCodeEnum::HttpUnauthorized->value,
                'data' => 'Login ou Senha inválidos'
            ]);

            $this->assertEquals($i + 1, $this->masterUser->refresh()->wrong_login_attempts);
            ;
        }

        $response = $this->postJson(route(RouteNameEnum::ApiV3AuthLogin), [
            'email' => $this->userMasterEmail,
            'password' => $this->userPassword,
        ])->assertOk();

        $response->assertJsonStructure(['status', 'data' => ['token']]);
    }
}
