<?php

namespace Tests\backend\Feature\UseCases\User;

use App\Enums\StatusEnum;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\backend\Falcon9Feature;

class BlockUserByWrongLoginUseCaseTest extends Falcon9Feature
{
    #[Test]
    public function blockUser()
    {
        // Testando login com sucesso
        $userCorrectLogin = ['email' => 'demo@demo.dev', 'password' => '12345678'];
        $responseCorrectLogin = $this->postJson('/auth', $userCorrectLogin, $this->headerWithoutUser)->json();

        $this->assertArrayHasKey('token', $responseCorrectLogin);
        $this->assertArrayHasKey('user', $responseCorrectLogin);

        // Testando login errado até bloquear o usuário
        $userWrongLogin = ['email' => 'demo@demo.dev', 'password' => $this->faker->text];

        for ($i = 0; $i <= config('app.max_wrong_login_attempts'); $i++) {
            $responseWrongLogin = $this->postJson('/auth', $userWrongLogin, $this->headerWithoutUser)->json()['message'];
            $this->assertEquals('Usuário ou senha incorreto!', $responseWrongLogin, "Fail on attempt $i");
        }

        // Testando login com usuário bloqueado
        $responseWrongLogin = $this->postJson('/auth', $userWrongLogin, $this->headerWithoutUser)->json();
        $this->assertEquals('Usuário inativo! Verifique seu e-mail para ativar sua conta.', $responseWrongLogin['message']);

        $userDB = User::where('email', 'demo@demo.dev')->first();
        $this->assertEquals(StatusEnum::Inactive->value, $userDB->status);

        // Desbloqueando usuário e testando login com sucesso
        $this->get("/active-user/{$userDB->verify_hash}", $this->headerWithoutUser);
        $responseCorrectLogin = $this->postJson('/auth', $userCorrectLogin, $this->headerWithoutUser)->json();

        $this->assertArrayHasKey('token', $responseCorrectLogin);
        $this->assertArrayHasKey('user', $responseCorrectLogin);
    }
}
