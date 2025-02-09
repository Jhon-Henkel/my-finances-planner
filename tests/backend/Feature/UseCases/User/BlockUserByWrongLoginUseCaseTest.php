<?php

namespace Tests\backend\Feature\UseCases\User;

use App\Enums\StatusEnum;
use App\Models\User;
use App\Tools\Cache\MfpCacheManager;
use App\Tools\Cache\MfpCacheManagerReal;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class BlockUserByWrongLoginUseCaseTest extends Falcon9FeatureWithTenantDatabase
{
    #[Test]
    public function blockUser()
    {
        $this->mockCacheManager();

        // Testando login com sucesso
        $userCorrectLogin = ['email' => 'pipeline@pipeline.dev', 'password' => '12345678'];
        $responseCorrectLogin = $this->postJson('/api/auth', $userCorrectLogin, $this->headerWithoutUser)->json();

        $this->assertArrayHasKey('token', $responseCorrectLogin);
        $this->assertArrayHasKey('user', $responseCorrectLogin);

        // Testando login errado até bloquear o usuário
        $userWrongLogin = ['email' => 'pipeline@pipeline.dev', 'password' => $this->faker->text];

        for ($i = 0; $i <= config('app.max_wrong_login_attempts'); $i++) {
            $responseWrongLogin = $this->postJson('/api/auth', $userWrongLogin, $this->headerWithoutUser)->json()['message'];
            $this->assertEquals('Usuário ou senha incorreto!', $responseWrongLogin, "Fail on attempt $i");
        }

        // Testando login com usuário bloqueado
        $responseWrongLogin = $this->postJson('/api/auth', $userWrongLogin, $this->headerWithoutUser)->json();
        $this->assertEquals('Usuário inativo! Verifique seu e-mail para ativar sua conta.', $responseWrongLogin['message']);

        $userDB = User::where('email', 'pipeline@pipeline.dev')->first();
        $this->assertEquals(StatusEnum::Inactive->value, $userDB->status);

        // Desbloqueando usuário e testando login com sucesso
        $this->get("/active-user/{$userDB->verify_hash}", $this->headerWithoutUser);
        $responseCorrectLogin = $this->postJson('/api/auth', $userCorrectLogin, $this->headerWithoutUser)->json();

        $this->assertArrayHasKey('token', $responseCorrectLogin);
        $this->assertArrayHasKey('user', $responseCorrectLogin);
    }
}
