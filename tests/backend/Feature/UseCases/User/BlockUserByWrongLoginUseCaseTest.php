<?php

namespace Tests\backend\Feature\UseCases\User;

use App\Enums\StatusEnum;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\backend\Falcon9Feature;

class BlockUserByWrongLoginUseCaseTest extends Falcon9Feature
{
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'MFP-TOKEN' => config('app.mfp_token'),
        ];
    }

    #[Test]
    public function blockUser()
    {
        // Testando login com sucesso
        $user = $this->createNewUser();

        $userCorrectLogin = ['email' => $user['email'], 'password' => $user['password']];
        $responseCorrectLogin = $this->postJson('/auth', $userCorrectLogin, $this->headers)->json();

        $this->assertArrayHasKey('token', $responseCorrectLogin);
        $this->assertArrayHasKey('user', $responseCorrectLogin);

        // Testando login errado até bloquear o usuário
        $userWrongLogin = ['email' => $user['email'], 'password' => $this->faker->text];

        for ($i = 0; $i <= config('app.max_wrong_login_attempts'); $i++) {
            $responseWrongLogin = $this->postJson('/auth', $userWrongLogin, $this->headers)->json()['message'];
            $this->assertEquals('Usuário ou senha incorreto!', $responseWrongLogin, "Fail on attempt $i");
        }

        // Testando login com usuário bloqueado
        $responseWrongLogin = $this->postJson('/auth', $userWrongLogin, $this->headers)->json();
        $this->assertEquals('Usuário inativo! Verifique seu e-mail para ativar sua conta.', $responseWrongLogin['message']);

        $userDB = User::where('email', $user['email'])->first();
        $this->assertEquals(StatusEnum::Inactive->value, $userDB->status);

        // Desbloqueando usuário e testando login com sucesso
        $this->get("/active-user/{$userDB->verify_hash}", $this->headers);
        $responseCorrectLogin = $this->postJson('/auth', $userCorrectLogin, $this->headers)->json();

        $this->assertArrayHasKey('token', $responseCorrectLogin);
        $this->assertArrayHasKey('user', $responseCorrectLogin);
    }
}
