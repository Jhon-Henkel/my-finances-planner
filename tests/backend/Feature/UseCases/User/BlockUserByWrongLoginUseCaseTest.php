<?php

namespace Tests\backend\Feature\UseCases\User;

use App\Enums\StatusEnum;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class BlockUserByWrongLoginUseCaseTest extends Falcon9FeatureWithTenantDatabase
{
    #[Test]
    public function blockUser()
    {
        $this->mockCacheManager();

        // Testando login com sucesso
        $userCorrectLogin = ['email' => $this->user->email, 'password' => '12345678'];
        $responseCorrectLogin = $this->postJson('/api/auth', $userCorrectLogin, $this->headerWithoutUser)->json();

        dd($responseCorrectLogin);
        $this->assertArrayHasKey('token', $responseCorrectLogin, 'Primeira Etapa');
        $this->assertArrayHasKey('user', $responseCorrectLogin, 'Primeira Etapa');

        // Testando login errado até bloquear o usuário
        $userWrongLogin = ['email' => $this->user->email, 'password' => $this->faker->text];

        for ($i = 0; $i <= config('app.max_wrong_login_attempts'); $i++) {
            $responseWrongLogin = $this->postJson('/api/auth', $userWrongLogin, $this->headerWithoutUser)->json()['message'];
            $this->assertEquals('Usuário ou senha incorreto!', $responseWrongLogin, "Fail on attempt $i");
        }

        // Testando login com usuário bloqueado
        $responseWrongLogin = $this->postJson('/api/auth', $userWrongLogin, $this->headerWithoutUser)->json();
        $this->assertEquals('Usuário inativo! Verifique seu e-mail para ativar sua conta.', $responseWrongLogin['message']);

        /** @var User $userDB */
        $userDB = User::where('email', $this->user->email)->first();
        $this->assertEquals(StatusEnum::Inactive->value, $userDB->status);

        // Desbloqueando usuário e testando login com sucesso
        $this->get("/active-user/{$userDB->verify_hash}", $this->headerWithoutUser);
        $responseCorrectLogin = $this->postJson('/api/auth', $userCorrectLogin, $this->headerWithoutUser)->json();

        $this->assertArrayHasKey('token', $responseCorrectLogin, 'Segunda Etapa');
        $this->assertArrayHasKey('user', $responseCorrectLogin, 'Segunda Etapa');
    }
}
