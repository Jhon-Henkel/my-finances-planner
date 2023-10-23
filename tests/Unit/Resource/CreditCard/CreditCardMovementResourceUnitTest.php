<?php

namespace Tests\Unit\Resource\CreditCard;

use App\Exceptions\NotImplementedException;
use App\Resources\CreditCard\CreditCardMovementResource;
use Tests\Falcon9;

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
}