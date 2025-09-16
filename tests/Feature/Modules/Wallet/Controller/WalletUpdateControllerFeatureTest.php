<?php

namespace Feature\Modules\Wallet\Controller;

use App\Enums\RouteNameEnum;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Enum\StatusYesNoEnum;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class WalletUpdateControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        Movement::where('description', 'atualização saldo carteira')->delete();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        Movement::where('description', 'atualização saldo carteira')->delete();
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testRoute()
    {
        $wallet = $this->createWallet();

        $this->putJson(route(RouteNameEnum::ApiV3WalletUpdate, [$wallet->id]), [
            'name' => self::WALLET_NAME,
            'hideValue' => true,
            'amount' => 10,
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->assertOk();

        $this->assertDatabaseHas(Wallet::class, [
            'name' => self::WALLET_NAME,
            'amount' => 10,
            'status' => StatusActiveInactiveEnum::Active->value,
            'hide_value' => StatusYesNoEnum::Yes->value,
        ]);
    }

    public function testIncreaseAmountCreatesGainMovement(): void
    {
        $wallet = $this->createWallet();

        $this->putJson(route(RouteNameEnum::ApiV3WalletUpdate, [$wallet->id]), [
            'name' => self::WALLET_NAME,
            'hideValue' => true,
            'amount' => 130.55,
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->assertOk();

        $wallet->refresh();
        $this->assertEquals(130.55, $wallet->amount);

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $wallet->id,
            'description' => 'atualização saldo carteira',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 30.55,
        ]);
    }

    public function testDecreaseAmountCreatesSpentMovement(): void
    {
        $wallet = $this->createWallet();

        $this->putJson(route(RouteNameEnum::ApiV3WalletUpdate, [$wallet->id]), [
            'name' => self::WALLET_NAME,
            'hideValue' => false,
            'amount' => 20.00,
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->assertOk();

        $wallet->refresh();
        $this->assertEquals(20.00, $wallet->amount);

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $wallet->id,
            'description' => 'atualização saldo carteira',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 80.00,
        ]);
    }

    public function testNoChangeDoesNotCreateMovement(): void
    {
        $wallet = $this->createWallet();

        $this->putJson(route(RouteNameEnum::ApiV3WalletUpdate, [$wallet->id]), [
            'name' => self::WALLET_NAME,
            'hideValue' => false,
            'amount' => 100.00,
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->assertOk();

        $this->assertDatabaseMissing(Movement::class, [
            'wallet_id' => $wallet->id,
            'description' => 'Atualização saldo carteira',
        ]);
    }
}
