<?php

namespace Tests\backend\Unit\Resource\CreditCard;

use App\DTO\CreditCard\CreditCardMovementDTO;
use App\Exceptions\NotImplementedException;
use App\Resources\CreditCard\CreditCardMovementResource;
use Tests\backend\Falcon9;

class CreditCardMovementResourceUnitTest extends Falcon9
{
    protected CreditCardMovementResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = new CreditCardMovementResource();
    }

    public function testArrayToDto()
    {
        $dto = $this->resource->arrayToDto([
            'id' => 1,
            'credit_card_id' => 1,
            'description' => 'Test',
            'type' => 'Test',
            'amount' => 100,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(1, $dto->getCreditCardId());
        $this->assertEquals('Test', $dto->getDescription());
        $this->assertEquals('Test', $dto->getType());
        $this->assertEquals(100, $dto->getAmount());
        $this->assertEquals('2021-01-01 00:00:00', $dto->getCreatedAt());
        $this->assertEquals('2021-01-01 00:00:00', $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $dto = $this->resource->dtoToArray(
            $this->resource->arrayToDto([
                'id' => 1,
                'credit_card_id' => 1,
                'description' => 'Test',
                'type' => 'Test',
                'amount' => 100,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ])
        );

        $this->assertEquals(1, $dto['credit_card_id']);
        $this->assertEquals('Test', $dto['description']);
        $this->assertEquals('Test', $dto['type']);
        $this->assertEquals(100, $dto['amount']);
    }

    public function testDtoToVo()
    {
        $this->expectException(NotImplementedException::class);
        $this->resource->dtoToVo(
            $this->resource->arrayToDto([
                'id' => 1,
                'credit_card_id' => 1,
                'description' => 'Test',
                'type' => 'Test',
                'amount' => 100,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ])
        );
    }

    public function testConvertCreditCardMovementsToMovements()
    {
        $creditCardMovementDto = new CreditCardMovementDTO(1, 2, 'Ds teste', 3, 10.90);

        $movements = $this->resource->convertCreditCardMovementsToMovements([$creditCardMovementDto]);

        $this->assertIsArray($movements);
        $this->assertEquals(1, $movements[0]->getId());
        $this->assertEquals(3, $movements[0]->getType());
        $this->assertEquals('Ds teste', $movements[0]->getDescription());
        $this->assertEquals(10.90, $movements[0]->getAmount());
        $this->assertNull($movements[0]->getCreatedAt());
        $this->assertNull($movements[0]->getUpdatedAt());
    }
}
