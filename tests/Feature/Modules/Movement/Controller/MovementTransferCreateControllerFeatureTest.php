<?php

namespace Tests\Feature\Modules\Movement\Controller;

use App\Infra\Enum\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;

class MovementTransferCreateControllerFeatureTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Movement::whereIn('description', ['Transferência - saída', 'Transferência - entrada'])->delete();
        Wallet::whereIn('name', ['wallet_origin_php_unit', 'wallet_dest_php_unit'])->delete();
    }

    protected function tearDown(): void
    {
        Movement::whereIn('description', ['Transferência - saída', 'Transferência - entrada'])->delete();
        Wallet::whereIn('name', ['wallet_origin_php_unit', 'wallet_dest_php_unit'])->delete();
        parent::tearDown();
    }

    public function testRouteAndWalletsAffected()
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

        $this->postJson(route(RouteNameEnum::ApiV3MovementTransferCreate), [
            'originWalletId' => $origin->id,
            'destinationWalletId' => $dest->id,
            'amount' => 75.55,
        ])->assertCreated();

        $origin->refresh();
        $dest->refresh();

        $this->assertEquals(124.45, $origin->amount);
        $this->assertEquals(125.55, $dest->amount);

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $origin->id,
            'type' => MovementTypeEnum::Transfer->value,
            'amount' => 75.55,
            'description' => 'Transferência - saída'
        ]);

        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $dest->id,
            'type' => MovementTypeEnum::Transfer->value,
            'amount' => 75.55,
            'description' => 'Transferência - entrada'
        ]);
    }
}
