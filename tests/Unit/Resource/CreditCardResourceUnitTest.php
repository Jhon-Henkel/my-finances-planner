<?php

namespace Tests\Unit\Resource;

use App\DTO\CreditCardDTO;
use App\Enums\BasicFieldsEnum;
use App\Resources\CreditCardResource;
use Tests\TestCase;

class CreditCardResourceUnitTest extends TestCase
{
    private CreditCardResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = $this->app->make('App\Resources\CreditCardResource');
    }

    public function testArrayToDto()
    {
        $item = [];
        $item[BasicFieldsEnum::ID] = 1;
        $item[BasicFieldsEnum::NAME] = 'Test';
        $item[BasicFieldsEnum::LIMIT] = 1000;
        $item[BasicFieldsEnum::DUE_DATE_DB] = 16;
        $item[BasicFieldsEnum::CLOSING_DAY_DB] = 1;
        $item[BasicFieldsEnum::CREATED_AT] = '2021-01-01';
        $item[BasicFieldsEnum::UPDATED_AT] = '2021-01-01';

        $dto = $this->resource->arrayToDto($item);

        $this->assertEquals($item[BasicFieldsEnum::ID], $dto->getId());
        $this->assertEquals($item[BasicFieldsEnum::NAME], $dto->getName());
        $this->assertEquals($item[BasicFieldsEnum::LIMIT], $dto->getLimit());
        $this->assertEquals($item[BasicFieldsEnum::DUE_DATE_DB], $dto->getDueDate());
        $this->assertEquals($item[BasicFieldsEnum::CLOSING_DAY_DB], $dto->getClosingDay());
        $this->assertEquals($item[BasicFieldsEnum::CREATED_AT], $dto->getCreatedAt());
        $this->assertEquals($item[BasicFieldsEnum::UPDATED_AT], $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $dto = new CreditCardDTO();
        $dto->setName('Test');
        $dto->setLimit(1000);
        $dto->setDueDate(16);
        $dto->setClosingDay(1);

        $array = $this->resource->dtoToArray($dto);

        $this->assertEquals($dto->getName(), $array[BasicFieldsEnum::NAME]);
        $this->assertEquals($dto->getLimit(), $array[BasicFieldsEnum::LIMIT]);
        $this->assertEquals($dto->getDueDate(), $array[BasicFieldsEnum::DUE_DATE_DB]);
        $this->assertEquals($dto->getClosingDay(), $array[BasicFieldsEnum::CLOSING_DAY_DB]);
    }

    public function testDtoToVo()
    {
        $dto = new CreditCardDTO();
        $dto->setId(1);
        $dto->setName('Test');
        $dto->setLimit(1000);
        $dto->setDueDate(16);
        $dto->setClosingDay(1);
        $dto->setCreatedAt('2021-01-01');
        $dto->setUpdatedAt('2021-01-01');

        $vo = $this->resource->dtoToVo($dto);

        $this->assertEquals($dto->getId(), $vo->id);
        $this->assertEquals($dto->getName(), $vo->name);
        $this->assertEquals($dto->getLimit(), $vo->limit);
        $this->assertEquals($dto->getDueDate(), $vo->dueDate);
        $this->assertEquals($dto->getClosingDay(), $vo->closingDay);
        $this->assertEquals($dto->getCreatedAt(), $vo->createdAt);
        $this->assertEquals($dto->getUpdatedAt(), $vo->updatedAt);
    }

    public function testTransactionToInvoiceDTO()
    {
        $item = [];
        $item[BasicFieldsEnum::ID] = 1;
        $item[BasicFieldsEnum::CREDIT_CARD_ID_DB] = 1;
        $item[BasicFieldsEnum::NAME] = 'Test';
        $item[BasicFieldsEnum::VALUE] = 1000;
        $item[BasicFieldsEnum::NEXT_INSTALLMENT_DB] = '2021-11';
        $item[BasicFieldsEnum::INSTALLMENTS] = 1;

        $dto = $this->resource->transactionToInvoiceDTO($item);

        $this->assertEquals($item[BasicFieldsEnum::ID], $dto->getId());
        $this->assertEquals($item[BasicFieldsEnum::CREDIT_CARD_ID_DB], $dto->getCountId());
        $this->assertEquals($item[BasicFieldsEnum::NAME], $dto->getDescription());
        $this->assertEquals($item[BasicFieldsEnum::VALUE], $dto->getValue());
        $this->assertEquals($item[BasicFieldsEnum::NEXT_INSTALLMENT_DB], $dto->getNextInstallment());
        $this->assertEquals(11, $dto->getNextInstallmentMonth());
        $this->assertEquals($item[BasicFieldsEnum::INSTALLMENTS], $dto->getInstallments());
    }
}