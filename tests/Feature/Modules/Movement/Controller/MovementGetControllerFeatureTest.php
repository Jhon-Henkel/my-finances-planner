<?php

namespace Feature\Modules\Movement\Controller;

use App\Infra\Enum\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class MovementGetControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        Movement::whereIn('description', ['Get movimento'])->delete();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        Movement::whereIn('description', ['Get movimento'])->delete();
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testGetMovementById()
    {
        $wallet = $this->createWallet();

        $movement = Movement::create([
            'wallet_id' => $wallet->id,
            'description' => 'Get movimento',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 12.34,
        ]);

        $response = $this->getJson(route(RouteNameEnum::ApiV3MovementGet, ['id' => $movement->id]));
        $response->assertOk();

        $response->assertJsonPath('data.id', $movement->id);
        $response->assertJsonPath('data.wallet_id', $wallet->id);
        $response->assertJsonPath('data.description', 'Get movimento');
        $response->assertJsonPath('data.type', MovementTypeEnum::Gain->value);
        $response->assertJsonPath('data.amount', '12.34');
    }
}
