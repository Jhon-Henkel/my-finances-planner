<?php

namespace Tests\backend\Unit\Resource\Movement;

use App\DTO\Movement\MovementDTO;
use App\Resources\Movement\MovementResource;
use Tests\backend\Falcon9;

class MovementResourceUnitTest extends Falcon9
{
    private MovementResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = app(MovementResource::class);
    }

    public function testArrayToDto()
    {
        $item = [
            'id' => 1,
            'wallet_id' => 1,
            'description' => 'Test',
            'type' => 2,
            'amount' => 100,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ];

        $dto = $this->resource->arrayToDto($item);

        $this->assertEquals($item['id'], $dto->getId());
        $this->assertEquals($item['wallet_id'], $dto->getWalletId());
        $this->assertEquals($item['description'], $dto->getDescription());
        $this->assertEquals($item['type'], $dto->getType());
        $this->assertEquals($item['amount'], $dto->getAmount());
        $this->assertEquals($item['created_at'], $dto->getCreatedAt());
        $this->assertEquals($item['updated_at'], $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $dto = new MovementDTO();
        $dto->setId(1);
        $dto->setWalletId(1);
        $dto->setDescription('Test');
        $dto->setType(2);
        $dto->setAmount(100);
        $dto->setCreatedAt('2021-01-01 00:00:00');
        $dto->setUpdatedAt('2021-01-01 00:00:00');

        $item = $this->resource->dtoToArray($dto);

        $this->assertEquals($dto->getWalletId(), $item['wallet_id']);
        $this->assertEquals($dto->getDescription(), $item['description']);
        $this->assertEquals($dto->getType(), $item['type']);
        $this->assertEquals($dto->getAmount(), $item['amount']);
    }

    public function testDtoToVo()
    {
        $dto = new \App\DTO\Movement\MovementDTO();
        $dto->setId(1);
        $dto->setWalletId(1);
        $dto->setWalletName('Test');
        $dto->setDescription('Test');
        $dto->setType(2);
        $dto->setAmount(100);
        $dto->setCreatedAt('2021-01-01 00:00:00');
        $dto->setUpdatedAt('2021-01-01 00:00:00');

        $vo = $this->resource->dtoToVo($dto);

        $this->assertEquals($dto->getId(), $vo->id);
        $this->assertEquals($dto->getWalletId(), $vo->walletId);
        $this->assertEquals($dto->getWalletName(), $vo->walletName);
        $this->assertEquals($dto->getDescription(), $vo->description);
        $this->assertEquals($dto->getType(), $vo->type);
        $this->assertEquals($dto->getAmount(), $vo->amount);
        $this->assertEquals($dto->getCreatedAt(), $vo->createdAt);
        $this->assertEquals($dto->getUpdatedAt(), $vo->updatedAt);
    }

    public function testPopulateMovementForWalletUpdate()
    {
        $value = 100;
        $walletId = 1;

        $dto = $this->resource->populateMovementForWalletUpdate($value, $walletId);

        $this->assertEquals($walletId, $dto->getWalletId());
        $this->assertEquals($value, $dto->getAmount());
        $this->assertEquals($value > 0 ? 6 : 5, $dto->getType());
    }
}
