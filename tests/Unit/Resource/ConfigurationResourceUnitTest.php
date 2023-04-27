<?php

namespace Tests\Unit\Resource;

use App\DTO\ConfigurationDTO;
use App\Resources\ConfigurationResource;
use Monolog\Test\TestCase;

class ConfigurationResourceUnitTest extends TestCase
{
    private ConfigurationResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = new ConfigurationResource();
    }

    public function testArrayToDto()
    {
        $array = [
            'id' => 1,
            'name' => 'name',
            'value' => 'value',
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2022-10-15 00:00:00',
        ];

        $dto = $this->resource->arrayToDto($array);

        $this->assertEquals($array['id'], $dto->getId());
        $this->assertEquals($array['name'], $dto->getName());
        $this->assertEquals($array['value'], $dto->getValue());
        $this->assertEquals($array['created_at'], $dto->getCreatedAt());
        $this->assertEquals($array['updated_at'], $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $dto = new ConfigurationDTO();
        $dto->setName('name');
        $dto->setValue('value');

        $array = $this->resource->dtoToArray($dto);

        $this->assertEquals($dto->getName(), $array['name']);
        $this->assertEquals($dto->getValue(), $array['value']);
    }

    public function testDtoToVo()
    {
        $dto = new ConfigurationDTO();
        $dto->setId(1);
        $dto->setName('name');
        $dto->setValue('value');
        $dto->setCreatedAt('2021-01-01 00:00:00');
        $dto->setUpdatedAt('2022-10-15 00:00:00');

        $vo = $this->resource->dtoToVo($dto);

        $this->assertEquals($dto->getName(), $vo->name);
        $this->assertEquals($dto->getValue(), $vo->value);
    }
}