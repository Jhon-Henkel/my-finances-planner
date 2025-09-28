<?php

namespace Tests\Feature\Modules\Wallet\Controller;

use App\Infra\Enum\RouteNameEnum;
use App\Models\Wallet\Wallet;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class WalletDeleteControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testRoute()
    {
        $wallet = $this->createWallet();

        $this->deleteJson(route(RouteNameEnum::ApiV3WalletDelete, [$wallet->id]))->assertNoContent();

        $this->assertDatabaseMissing(Wallet::class, [
            'name' => self::WALLET_NAME,
        ]);
    }
}
