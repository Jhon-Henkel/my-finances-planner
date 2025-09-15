<?php

namespace Feature\Modules\CreditCard\Controller;

use App\Enums\RouteNameEnum;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Models\CreditCard\CreditCard;
use Tests\FeatureTestCase;
use Tests\Trait\CreditCardTrait;

class CreditCardUpdateControllerFeatureTest extends FeatureTestCase
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
        $card = $this->createCreditCard();

        $this->putJson(route(RouteNameEnum::ApiV3CreditCardUpdate, [$card->id]), [
            'name' => self::CREDIT_CARD_NAME,
            'limit' => 2000.00,
            'dueDate' => 15,
            'closingDay' => 7,
            'status' => StatusActiveInactiveEnum::Active->value,
        ])->assertOk();

        $this->assertDatabaseHas(CreditCard::class, [
            'id' => $card->id,
            'name' => self::CREDIT_CARD_NAME,
            'limit' => 2000.00,
            'due_date' => 15,
            'closing_day' => 7,
            'status' => StatusActiveInactiveEnum::Active->value,
        ]);
    }
}
