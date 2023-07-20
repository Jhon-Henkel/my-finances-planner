<?php

namespace Tests\Unit\Http\Controllers;

use App\DTO\MailMessageDTO;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Models\User;
use App\Services\MailService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Factory;
use Mockery;
use Tests\Falcon9;

class AuthControllerUnitTest extends Falcon9
{
    public function testConstants()
    {
        $this->assertEquals(1, AuthController::INVALID_LOGIN_OR_PASSWORD_CODE);
        $this->assertEquals(2, AuthController::INACTIVE_USER_CODE);
        $this->assertEquals(3, AuthController::OK_CODE);
    }

    public function testFindUserForAuth()
    {
        $serviceMock = Mockery::mock(UserService::class)->makePartial();
        $serviceMock->shouldReceive('findUserByEmail')->once()->andReturn(new User());
        $this->app->instance(UserService::class, $serviceMock);

        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(User::class, $controller->findUserForAuth('email'));
    }

    public function testValidateLoginWithoutUser()
    {
        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();

        $this->assertEquals(1, $controller->validateLogin(null, 'password'));
    }

    public function testValidateLoginWithUserStatusInactive()
    {
        $user = new User();
        $user->status = 0;

        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();

        $this->assertEquals(2, $controller->validateLogin($user, 'password'));
    }

    public function testValidateLoginWithMaxWrongAttemptsDone()
    {
        $user = new User();
        $user->status = 1;
        $user->wrong_login_attempts = 6;

        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('inactiveUser')->once()->andReturn(true);
        $controller->shouldReceive('sendEmailInactiveUser')->once()->andReturn(true);

        $this->assertEquals(2, $controller->validateLogin($user, 'password'));
    }

    public function testValidateLoginWithWrongPassword()
    {
        $user = new User();
        $user->status = 1;
        $user->wrong_login_attempts = 0;
        $user->password = '123';

        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('inactiveUser')->never();
        $controller->shouldReceive('sendEmailInactiveUser')->never();
        $controller->shouldReceive('incrementWrongLoginAttempts')->once()->andReturn(true);

        $this->assertEquals(1, $controller->validateLogin($user, 'password'));
    }

    public function testValidateLoginWithValidPassword()
    {
        $userModelMock = Mockery::mock(User::class)->makePartial();
        $userModelMock->shouldReceive('save')->andReturn(true);
        $userModelMock->status = 1;
        $userModelMock->wrong_login_attempts = 0;
        $userModelMock->password = bcrypt('password');

        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('inactiveUser')->never();
        $controller->shouldReceive('sendEmailInactiveUser')->never();
        $controller->shouldReceive('incrementWrongLoginAttempts')->never();

        $this->assertEquals(3, $controller->validateLogin($userModelMock, 'password'));
    }

    public function testSendEmailInactiveUser()
    {
        $messageDTO = new MailMessageDTO(
            'email',
            'subject',
            'view',
            '',
            ['data'],
        );

        $mailService = Mockery::mock(MailService::class)->makePartial();
        $mailService->shouldReceive('sendEmail')->once()->andReturn(true);
        $this->app->instance(MailService::class, $mailService);

        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('generateDataForEmailInactiveUser')->once()->andReturn($messageDTO);
        $controller->sendEmailInactiveUser(new User());

        $this->assertTrue(true);
    }

    public function testGenerateDataForEmailInactiveUser()
    {
        $user = new User();
        $user->name = 'name';
        $user->verify_hash = 'hash';
        $user->email = 'email';

        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();

        $data = $controller->generateDataForEmailInactiveUser($user);

        $this->assertInstanceOf(MailMessageDTO::class, $data);
        $this->assertEquals('email', $data->getAddressee());
        $this->assertEquals('Ativação de usuário', $data->getSubject());
        $this->assertEquals('emails.activeUser', $data->getTempleteFile());
        $this->assertEquals('name', $data->getParams()['name']);
    }

    public function testMakeAuthUserResponseData()
    {
        $user = new User();
        $user->name = 'Joãozinho';
        $user->id = 1;
        $user->salary = 1300;

        $controller = Mockery::mock(AuthController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();

        $data = $controller->makeAuthUserResponseData($user);

        $this->assertIsArray($data);
        $this->arrayHasKey('token', $data);
        $this->arrayHasKey('user', $data);
        $this->assertIsString($data['token']);
        $this->assertEquals('Joãozinho', $data['user']['name']);
        $this->assertEquals(1, $data['user']['id']);
        $this->assertEquals(1300, $data['user']['salary']);
        $this->assertStringContainsString('Joãozinho', $data['user']['salutation']);
    }
}