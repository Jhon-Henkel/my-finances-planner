<?php

namespace Feature\Modules\Movement\Controller;

use App\Enums\RouteNameEnum;
use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Tests\FeatureTestCase;
use Tests\Trait\WalletTrait;

class MovementListControllerFeatureTest extends FeatureTestCase
{
    use WalletTrait;

    protected function setUp(): void
    {
        parent::setUp();
        Movement::whereIn('description', ['List m1', 'List m2'])->delete();
        $this->deleteWallet();
    }

    protected function tearDown(): void
    {
        Movement::whereIn('description', ['List m1', 'List m2'])->delete();
        $this->deleteWallet();
        parent::tearDown();
    }

    public function testListMovementsReturnsInsertedItems()
    {
        $wallet = $this->createWallet();

        Movement::create([
            'wallet_id' => $wallet->id,
            'description' => 'List m1',
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 5.00,
        ]);

        Movement::create([
            'wallet_id' => $wallet->id,
            'description' => 'List m2',
            'type' => MovementTypeEnum::Spent->value,
            'amount' => 3.21,
        ]);

        $response = $this->getJson(route(RouteNameEnum::ApiV3MovementList))->assertOk();

        $items = $response->json('data');

        $this->assertIsArray($items);

        $descriptions = array_column($items, 'description');

        $this->assertContains('List m1', $descriptions);
        $this->assertContains('List m2', $descriptions);
    }
}
