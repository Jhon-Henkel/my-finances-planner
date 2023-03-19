<?php

namespace Tests\Unit\DTO;

use App\DTO\ConfigurationDTO;
use Tests\TestCase;

class ConfigurationDtoUnitTest extends TestCase
{
    public function testConfigurationDto()
    {
        $dto = new ConfigurationDTO();
        $dto->setId(10);
        $dto->setName('qwe');
        $dto->setValue('edv');
        $dto->setCreatedAt('2022-10-01 00:00:00');
        $dto->setUpdatedAt('2023-01-15 10:50:43');

        $this->assertEquals(10, $dto->getId());
        $this->assertEquals('qwe', $dto->getName());
        $this->assertEquals('edv', $dto->getValue());
        $this->assertEquals('2022-10-01 00:00:00', $dto->getCreatedAt());
        $this->assertEquals('2023-01-15 10:50:43', $dto->getUpdatedAt());
    }
}