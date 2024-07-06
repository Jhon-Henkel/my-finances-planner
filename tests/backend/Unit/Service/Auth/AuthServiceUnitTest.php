<?php

namespace Tests\backend\Unit\Service\Auth;

use App\DTO\Mail\MailMessageDTO;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Log\AccessLogService;
use App\Services\Mail\MailService;
use App\Services\UserService;
use Mockery;
use Tests\backend\Falcon9;

class AuthServiceUnitTest extends Falcon9
{
    public function testConstants()
    {
        $this->assertEquals(1, AuthService::INVALID_LOGIN_OR_PASSWORD_CODE);
        $this->assertEquals(2, AuthService::INACTIVE_USER_CODE);
        $this->assertEquals(3, AuthService::OK_CODE);
    }

    public function testFindUserForAuth()
    {
        $serviceMock = Mockery::mock(UserService::class)->makePartial();
        $serviceMock->shouldReceive('findUserByEmail')->once()->andReturn(new User());

        $mocks = [
            $serviceMock,
            Mockery::mock(MailService::class)->makePartial(),
            Mockery::mock(AccessLogService::class)->makePartial()
        ];

        $service = Mockery::mock(AuthService::class, $mocks)->makePartial();
        $service->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(User::class, $service->findUserForAuth('email'));
    }

    public function testValidateLoginWithUserStatusInactive()
    {
        $user = new User();
        $user->status = 0;

        $service = Mockery::mock(AuthService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();

        $this->assertEquals(2, $service->validateLogin($user, 'password'));
    }

    public function testValidateLoginWithMaxWrongAttemptsDone()
    {
        $user = new User();
        $user->status = 1;
        $user->wrong_login_attempts = 6;

        $service = Mockery::mock(AuthService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('inactiveUser')->once()->andReturn(true);
        $service->shouldReceive('sendEmailInactiveUser')->once()->andReturn(true);

        $this->assertEquals(2, $service->validateLogin($user, 'password'));
    }

    public function testValidateLoginWithWrongPassword()
    {
        $user = new User();
        $user->status = 1;
        $user->wrong_login_attempts = 0;
        $user->password = '123';

        $service = Mockery::mock(AuthService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('inactiveUser')->never();
        $service->shouldReceive('sendEmailInactiveUser')->never();
        $service->shouldReceive('incrementWrongLoginAttempts')->once()->andReturn(true);

        $this->assertEquals(1, $service->validateLogin($user, 'password'));
    }

    public function testValidateLoginWithValidPassword()
    {
        $userModelMock = Mockery::mock(User::class)->makePartial();
        $userModelMock->shouldReceive('save')->andReturn(true);
        $userModelMock->status = 1;
        $userModelMock->wrong_login_attempts = 0;
        $userModelMock->password = bcrypt('password');

        $service = Mockery::mock(AuthService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('inactiveUser')->never();
        $service->shouldReceive('sendEmailInactiveUser')->never();
        $service->shouldReceive('incrementWrongLoginAttempts')->never();

        $this->assertEquals(3, $service->validateLogin($userModelMock, 'password'));
    }

    public function testValidateLoginWithoutUser()
    {
        $service = Mockery::mock(AuthService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();

        $this->assertEquals(1, $service->validateLogin(null, 'password'));
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

        $mocks = [
            Mockery::mock(UserService::class)->makePartial(),
            $mailService,
            Mockery::mock(AccessLogService::class)->makePartial()
        ];

        $service = Mockery::mock(AuthService::class, $mocks)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('generateDataForEmailInactiveUser')->once()->andReturn($messageDTO);
        $service->sendEmailInactiveUser(new User());

        $this->assertTrue(true);
    }

    public function testGenerateDataForEmailInactiveUser()
    {
        $user = new User();
        $user->name = 'name';
        $user->verify_hash = 'hash';
        $user->email = 'email';
        $service = Mockery::mock(AuthService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();

        $data = $service->generateDataForEmailInactiveUser($user);

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
        $user->market_planner_value = 10;
        $user->email = 'email@email.com';

        $service = Mockery::mock(AuthService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();

        $data = $service->makeAuthUserResponseData($user);

        $this->assertIsArray($data);
        $this->arrayHasKey('token', $data);
        $this->arrayHasKey('user', $data);
        $this->assertIsString($data['token']);
        $this->assertEquals('Joãozinho', $data['user']['name']);
        $this->assertEquals(1, $data['user']['id']);
        $this->assertEquals(1300, $data['user']['salary']);
        $this->assertEquals(10, $data['user']['marketPlannerValue']);
        $this->assertEquals('email@email.com', $data['user']['email']);
        $this->assertStringContainsString('Joãozinho', $data['user']['salutation']);
    }

    public function testSaveAccessLog()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'Joãozinho';
        $user->email = 'email';
        $user->status = 1;
        $user->wrong_login_attempts = 0;
        $user->password = bcrypt('password');
        $user->tenant_id = 1;

        $_SERVER['REMOTE_ADDR'] = '192.168.1.1';
        $_SERVER['HTTP_USER_AGENT'] = 'user_agent';

        $accessLogMock = Mockery::mock(AccessLogService::class)->makePartial();
        $accessLogMock->shouldReceive('saveAccessLog')->once()->andReturn(true);

        $mocks = [
            Mockery::mock(UserService::class)->makePartial(),
            Mockery::mock(MailService::class)->makePartial(),
            $accessLogMock
        ];

        $service = Mockery::mock(AuthService::class, $mocks)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->saveAccessLog($user, 1, 'message');

        $this->assertTrue(true);
    }
}
