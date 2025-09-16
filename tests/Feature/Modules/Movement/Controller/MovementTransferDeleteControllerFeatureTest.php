<?php

namespace Feature\Modules\Movement\Controller;

use App\Enums\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Models\Wallet\Wallet;
use Tests\FeatureTestCase;

class MovementTransferDeleteControllerFeatureTest extends FeatureTestCase
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

    public function testDeleteOutgoingTransferRevertsOriginWallet()
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

        $out = Movement::query()
            ->where('wallet_id', $origin->id)
            ->where('description', 'Transferência - saída')
            ->firstOrFail();

        $this->deleteJson(route(RouteNameEnum::ApiV3MovementTransferDelete, ['id' => $out->id]))
            ->assertNoContent();

        $origin->refresh();
        $this->assertEquals(200.00, $origin->amount);

        $dest->refresh();
        $this->assertEquals(125.55, $dest->amount);

        $this->assertDatabaseMissing(Movement::class, ['id' => $out->id]);
        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $dest->id,
            'description' => 'Transferência - entrada',
            'amount' => 75.55,
        ]);
    }

    public function testDeleteIncomingTransferRevertsDestinationWallet()
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
            'amount' => 20.00,
        ])->assertCreated();

        $in = Movement::query()
            ->where('wallet_id', $dest->id)
            ->where('description', 'Transferência - entrada')
            ->firstOrFail();

        $this->deleteJson(route(RouteNameEnum::ApiV3MovementTransferDelete, ['id' => $in->id]))
            ->assertNoContent();

        $dest->refresh();
        $this->assertEquals(50.00, $dest->amount);

        $origin->refresh();
        $this->assertEquals(180.00, $origin->amount);

        $this->assertDatabaseMissing(Movement::class, ['id' => $in->id]);
        $this->assertDatabaseHas(Movement::class, [
            'wallet_id' => $origin->id,
            'description' => 'Transferência - saída',
            'amount' => 20.00,
        ]);
    }
}
