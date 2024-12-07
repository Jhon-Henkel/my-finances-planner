<?php

namespace Tests\backend\Unit\Resource;

use App\Modules\Wallet\Resource\WalletResource;
use Tests\backend\Falcon9;

class WalletResourceUnitTest extends Falcon9
{
    private WalletResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = app(WalletResource::class);
    }

    public function testArrayToDto()
    {
        $array = [
            'id' => 1,
            'name' => 'Test',
            'type' => 1,
            'amount' => 100.00,
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ];

        $dto = $this->resource->arrayToDto($array);

        $this->assertEquals($array['id'], $dto->getId());
        $this->assertEquals($array['name'], $dto->getName());
        $this->assertEquals($array['type'], $dto->getType());
        $this->assertEquals($array['amount'], $dto->getAmount());
        $this->assertEquals($array['created_at'], $dto->getCreatedAt());
        $this->assertEquals($array['updated_at'], $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $dto = $this->resource->arrayToDto([
            'id' => 1,
            'name' => 'Test',
            'type' => 1,
            'amount' => 100.00,
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ]);

        $array = $this->resource->dtoToArray($dto);

        $this->assertEquals($dto->getId(), $array['id']);
        $this->assertEquals($dto->getName(), $array['name']);
        $this->assertEquals($dto->getType(), $array['type']);
        $this->assertEquals($dto->getAmount(), $array['amount']);
    }

    public function testDtoToVo()
    {
        $dto = $this->resource->arrayToDto([
            'id' => 1,
            'name' => 'Test',
            'type' => 1,
            'amount' => 100.00,
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ]);

        $vo = $this->resource->dtoToVo($dto);

        $this->assertEquals($dto->getId(), $vo->id);
        $this->assertEquals($dto->getName(), $vo->name);
        $this->assertEquals($dto->getType(), $vo->type);
        $this->assertEquals($dto->getAmount(), $vo->amount);
        $this->assertEquals($dto->getCreatedAt(), $vo->createdAt);
        $this->assertEquals($dto->getUpdatedAt(), $vo->updatedAt);
    }
}
