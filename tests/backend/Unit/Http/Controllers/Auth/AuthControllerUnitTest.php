<?php

namespace Tests\backend\Unit\Http\Controllers\Auth;

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\backend\Falcon9;

class AuthControllerUnitTest extends Falcon9
{
    protected function getAuthRequest(): Request
    {
        $data = new ParameterBag();
        $data->set('email', $this->faker->email);
        $data->set('password', $this->faker->password);
        $request = new Request();
        $request->setJson($data);
        $request->headers->set('content-type', 'application/json');
        $request->headers->set('accept', 'application/json');
        return $request;
    }

    #[TestDox('Testando sem usuário registrado na base')]
    public function testAuthTestOne()
    {
        $authUserServiceMock = Mockery::mock(AuthService::class)->makePartial();
        $authUserServiceMock->shouldReceive('findUserForAuth')->once()->andReturn(null);

        $authControllerMock = Mockery::mock(AuthController::class, [$authUserServiceMock])->makePartial();
        $response = $authControllerMock->auth($this->getAuthRequest());

        $this->assertEquals(401, $response->getStatusCode());
    }

    #[TestDox('Testando com usuário registrado na base, usuário inativo')]
    public function testAuthTestTwo()
    {
        $authUserServiceMock = Mockery::mock(AuthService::class)->makePartial();
        $authUserServiceMock->shouldReceive('findUserForAuth')->once()->andReturn(new User());
        $authUserServiceMock->shouldReceive('validateLogin')->once()->andReturn(AuthService::INACTIVE_USER_CODE);
        $authUserServiceMock->shouldReceive('saveAccessLog')->once()->andReturn(true);

        $authControllerMock = Mockery::mock(AuthController::class, [$authUserServiceMock])->makePartial();
        $response = $authControllerMock->auth($this->getAuthRequest());

        $this->assertEquals(403, $response->getStatusCode());
    }

    #[TestDox('Testando com usuário registrado na base, usuário ativo, senha incorreta')]
    public function testAuthTestThree()
    {
        $authUserServiceMock = Mockery::mock(AuthService::class)->makePartial();
        $authUserServiceMock->shouldReceive('findUserForAuth')->once()->andReturn(new User());
        $authUserServiceMock->shouldReceive('validateLogin')->once()->andReturn(AuthService::INVALID_LOGIN_OR_PASSWORD_CODE);
        $authUserServiceMock->shouldReceive('saveAccessLog')->once()->andReturn(true);

        $authControllerMock = Mockery::mock(AuthController::class, [$authUserServiceMock])->makePartial();
        $response = $authControllerMock->auth($this->getAuthRequest());

        $this->assertEquals(401, $response->getStatusCode());
    }

    #[TestDox('Testando com usuário registrado na base, usuário ativo, senha correta')]
    public function testAuthTestFour()
    {
        $user = new User(['email' => $this->faker->email]);
        $authUserServiceMock = Mockery::mock(AuthService::class)->makePartial();
        $authUserServiceMock->shouldReceive('findUserForAuth')->once()->andReturn($user);
        $authUserServiceMock->shouldReceive('validateLogin')->once()->andReturn(AuthService::OK_CODE);
        $authUserServiceMock->shouldReceive('saveAccessLog')->once()->andReturn(true);
        $authUserServiceMock->shouldReceive('makeAuthUserResponseData')->once()->andReturn([]);

        $authControllerMock = Mockery::mock(AuthController::class, [$authUserServiceMock])->makePartial();
        $response = $authControllerMock->auth($this->getAuthRequest());

        $this->assertEquals(200, $response->getStatusCode());
    }

    #[TestDox('Testando com usuário registrado na base, usuário ativo, senha correta, erro inesperado ao realizar login')]
    public function testAuthTestFive()
    {
        $authUserServiceMock = Mockery::mock(AuthService::class)->makePartial();
        $authUserServiceMock->shouldReceive('findUserForAuth')->once()->andReturn(new User());
        $authUserServiceMock->shouldReceive('validateLogin')->once()->andReturn(0);
        $authUserServiceMock->shouldReceive('saveAccessLog')->once()->andReturn(true);

        $authControllerMock = Mockery::mock(AuthController::class, [$authUserServiceMock])->makePartial();
        $response = $authControllerMock->auth($this->getAuthRequest());

        $this->assertEquals(500, $response->getStatusCode());
    }
}
