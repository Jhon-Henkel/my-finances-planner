<?php

namespace Feature\Modules\CreditCard\Controller;

use App\Enums\RouteNameEnum;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Models\CreditCard\CreditCard;
use Tests\FeatureTestCase;
use Tests\Trait\CreditCardTrait;

class CreditCardCreateControllerFeatureTest extends FeatureTestCase
{
    use CreditCardTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteCreditCard();
    }

    protected function tearDown(): void
    {
        $this->deleteCreditCard();
        parent::tearDown();
    }

    public function testRoute()
    {
        $this->postJson(route(RouteNameEnum::ApiV3CreditCardCreate), [
            'name' => self::CREDIT_CARD_NAME,
            'limit' => 1500.55,
            'dueDate' => 12,
            'closingDay' => 5,
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->assertCreated();

        $this->assertDatabaseHas(CreditCard::class, [
            'name' => self::CREDIT_CARD_NAME,
            'limit' => 1500.55,
            'due_date' => 12,
            'closing_day' => 5,
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);
    }
}
