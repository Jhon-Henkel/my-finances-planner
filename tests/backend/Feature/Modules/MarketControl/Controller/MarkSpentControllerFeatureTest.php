<?php

namespace Tests\backend\Feature\Modules\MarketControl\Controller;

use App\Models\WalletModel;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class MarkSpentControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    protected string $uri = '/api/mfp/market-control-app/movement';

    public function testShouldReturnErrorWhenDataIsInvalid(): void
    {
        $response = $this->postJson($this->uri, ['abc' => 'def'], $this->makeApiHeaders());
        $response->assertStatus(201);
        $response->assertJson(['status' => 'error']);
    }

    public function testShouldReturnOkWhenDataIsValid(): void
    {
        $wallet = WalletModel::create(['name' => 'Test Wallet', 'amount' => 1000, 'type' => 1]);

        $response = $this->postJson($this->uri, [
            'wallet_id' => $wallet->id,
            'amount' => 100,
        ], $this->makeApiHeaders());

        $response->assertStatus(201);
        $response->assertJson(['status' => 'ok']);

        $wallet->refresh();
        $this->assertEquals(900, $wallet->amount);
    }
}
