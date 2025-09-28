<?php

namespace Feature\Modules\Movement\Controller;

use App\Infra\Enum\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class MovementUpdateControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        Movement::whereIn('description', ['Upd gasto', 'Upd ganho', 'Transferência - saída', 'Transferência - entrada'])->delete();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        Movement::whereIn('description', ['Upd gasto', 'Upd ganho', 'Transferência - saída', 'Transferência - entrada'])->delete();
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testUpdateGainToSpentAdjustsWallet()
    {
        $wallet = $this->createWallet();

        $movement = Movement::create([
            'wallet_id' => $wallet->id,
            'description' => 'Upd ganho',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 30.00,
        ]);

        $wallet->amount += 30.00;
        $wallet->save();

        $this->assertEquals(130.00, $wallet->amount);

        $this->putJson(route(RouteNameEnum::ApiV3MovementUpdate, [$movement->id]), [
            'description' => 'Upd gasto',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 10.00,
        ])->assertOk();

        $wallet->refresh();
        $this->assertEquals(90.00, $wallet->amount);

        $this->assertDatabaseHas(Movement::class, [
            'id' => $movement->id,
            'description' => 'Upd gasto',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 10.00,
        ]);
    }

    public function testUpdateSpentToGainAdjustsWallet()
    {
        $wallet = $this->createWallet();

        $movement = Movement::create([
            'wallet_id' => $wallet->id,
            'description' => 'Upd gasto',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 20.00,
        ]);

        $wallet->amount -= 20.00;
        $wallet->save();

        $this->assertEquals(80, $wallet->amount);

        $this->putJson(route(RouteNameEnum::ApiV3MovementUpdate, [$movement->id]), [
            'description' => 'Upd ganho',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 50.00,
        ])->assertOk();

        $wallet->refresh();
        $this->assertEquals(150.00, $wallet->amount);
    }

    public function testUpdateTransferIsRejected()
    {
        $origin = Wallet::create([
            'name' => 'wallet_origin_php_unit',
            'status' => 1,
            'amount' => 200.00,
            'hide_value' => false,
        ]);

        $out = Movement::create([
            'wallet_id' => $origin->id,
            'description' => 'Transferência - saída',
            'type' => MovementTypeEnum::Transfer->value,
            'amount' => 10.00,
        ]);

        $this->putJson(route(RouteNameEnum::ApiV3MovementUpdate, ['id' => $out->id]), [
            'description' => 'tentar editar',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 1,
        ])->assertBadRequest();
    }
}
