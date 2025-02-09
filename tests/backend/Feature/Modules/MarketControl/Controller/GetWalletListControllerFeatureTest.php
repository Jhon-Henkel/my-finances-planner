<?php

namespace Tests\backend\Feature\Modules\MarketControl\Controller;

use App\Models\WalletModel;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class GetWalletListControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    protected string $uri = '/api/mfp/market-control-app/wallets';

    public function testShouldReturnOkWhenDataIsValid(): void
    {
        WalletModel::create(['name' => 'Test Wallet 1', 'amount' => 11, 'type' => 1]);
        WalletModel::create(['name' => 'Test Wallet 2', 'amount' => 22, 'type' => 1]);
        WalletModel::create(['name' => 'Test Wallet 3', 'amount' => 33, 'type' => 1]);

        $response = $this->getJson($this->uri, $this->makeApiHeaders());

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Test Wallet 1']);
        $response->assertJsonFragment(['name' => 'Test Wallet 2']);
        $response->assertJsonFragment(['name' => 'Test Wallet 3']);
    }
}
