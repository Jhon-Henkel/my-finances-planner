<?php

namespace Feature\Modules\Movement\Controller;

use App\Infra\Enum\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class MovementDeleteControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        Movement::whereIn('description', ['Del teste ganho', 'Del teste gasto', 'Transferência - saída', 'Transferência - entrada'])->delete();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        Movement::whereIn('description', ['Del teste ganho', 'Del teste gasto', 'Transferência - saída', 'Transferência - entrada'])->delete();
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testDeleteGainRevertsWallet()
    {
        $wallet = $this->createWallet();

        $movement = Movement::create([
            'wallet_id' => $wallet->id,
            'description' => 'Del teste ganho',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 40.00,
        ]);

        $wallet->amount += 40.00;
        $wallet->save();

        $this->assertEquals(140.00, $wallet->amount);

        $this->deleteJson(route(RouteNameEnum::ApiV3MovementDelete, ['id' => $movement->id]))
            ->assertNoContent();

        $wallet->refresh();
        $this->assertEquals(100.00, $wallet->amount);
        $this->assertDatabaseMissing(Movement::class, ['id' => $movement->id]);
    }

    public function testDeleteSpentRevertsWallet()
    {
        $wallet = $this->createWallet();

        $movement = Movement::create([
            'wallet_id' => $wallet->id,
            'description' => 'Del teste gasto',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 25.00,
        ]);

        $wallet->amount -= 25.00;
        $wallet->save();

        $this->assertEquals(75.00, $wallet->amount);

        $this->deleteJson(route(RouteNameEnum::ApiV3MovementDelete, ['id' => $movement->id]))
            ->assertNoContent();

        $wallet->refresh();
        $this->assertEquals(100.00, $wallet->amount);
        $this->assertDatabaseMissing(Movement::class, ['id' => $movement->id]);
    }

    public function testDeleteTransferIsRejected()
    {
        $origin = Wallet::create([
            'name' => 'wallet_origin_php_unit',
            'status' => 1,
            'amount' => 200.00,
            'hide_value' => false,
        ]);

        $dest = Wallet::create([
            'name' => 'wallet_dest_php_unit',
            'status' => 1,
            'amount' => 50.00,
            'hide_value' => false,
        ]);

        $out = Movement::create([
            'wallet_id' => $origin->id,
            'description' => 'Transferência - saída',
            'type' => MovementTypeEnum::Transfer->value,
            'amount' => 10.00,
        ]);

        $in = Movement::create([
            'wallet_id' => $dest->id,
            'description' => 'Transferência - entrada',
            'type' => MovementTypeEnum::Transfer->value,
            'amount' => 10.00,
        ]);

        $this->deleteJson(route(RouteNameEnum::ApiV3MovementDelete, ['id' => $out->id]))
            ->assertBadRequest();

        $this->deleteJson(route(RouteNameEnum::ApiV3MovementDelete, ['id' => $in->id]))
            ->assertBadRequest();
    }
}
