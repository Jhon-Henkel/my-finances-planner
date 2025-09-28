<?php

namespace Feature\Modules\Movement\Controller;

use App\Infra\Enum\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class MovementCreateControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        Movement::whereIn('description', ['Teste gasto', 'Teste ganho'])->delete();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        Movement::whereIn('description', ['Teste gasto', 'Teste ganho'])->delete();
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testCreateGainAffectsWalletAndStoresMovement()
    {
        $wallet = $this->createWallet();

        $this->postJson(route(RouteNameEnum::ApiV3MovementCreate), [
            'walletId' => $wallet->id,
            'description' => 'Teste ganho',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 50.25,
        ])->assertCreated();

        $wallet->refresh();
        $this->assertEquals(150.25, $wallet->amount);

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $wallet->id,
            'description' => 'Teste ganho',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 50.25,
        ]);
    }

    public function testCreateSpentAffectsWalletAndStoresMovement()
    {
        $wallet = $this->createWallet();

        $this->postJson(route(RouteNameEnum::ApiV3MovementCreate), [
            'walletId' => $wallet->id,
            'description' => 'Teste gasto',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 25.10,
        ])->assertCreated();

        $wallet->refresh();
        $this->assertEquals(74.90, $wallet->amount);

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $wallet->id,
            'description' => 'Teste gasto',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 25.10,
        ]);
    }

    public function testInvalidTypeIsRejected()
    {
        $wallet = $this->createWallet();

        $this->postJson(route(RouteNameEnum::ApiV3MovementCreate), [
            'walletId' => $wallet->id,
            'description' => 'Teste inválido',
            'type' => 9999,
            'amount' => 10,
        ])->assertBadRequest();
    }
}
