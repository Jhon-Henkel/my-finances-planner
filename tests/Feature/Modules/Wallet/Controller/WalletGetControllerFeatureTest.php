<?php

namespace Feature\Modules\Wallet\Controller;

use App\Enums\RouteNameEnum;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class WalletGetControllerFeatureTest extends FeatureTestCase
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

        $this->getJson(route(RouteNameEnum::ApiV3WalletGet, [$wallet->id]))->assertOk()->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'name',
                'hide_value',
                'amount',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
