<?php

namespace Tests\backend\Unit\Resource\CreditCard;

use App\DTO\CreditCard\CreditCardDTO;
use App\Resources\CreditCard\CreditCardResource;
use Tests\backend\Falcon9;

class CreditCardResourceUnitTest extends Falcon9
{
    private CreditCardResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = $this->app->make(CreditCardResource::class);
    }

    public function testArrayToDto()
    {
        $item = [];
        $item['id'] = 1;
        $item['name'] = 'Test';
        $item['limit'] = 1000;
        $item['due_date'] = 16;
        $item['closing_day'] = 1;
        $item['created_at'] = '2021-01-01';
        $item['updated_at'] = '2021-01-01';
        $item['status'] = true;

        $dto = $this->resource->arrayToDto($item);

        $this->assertEquals($item['id'], $dto->getId());
        $this->assertEquals($item['name'], $dto->getName());
        $this->assertEquals($item['limit'], $dto->getLimit());
        $this->assertEquals($item['due_date'], $dto->getDueDate());
        $this->assertEquals($item['closing_day'], $dto->getClosingDay());
        $this->assertEquals($item['created_at'], $dto->getCreatedAt());
        $this->assertEquals($item['updated_at'], $dto->getUpdatedAt());
        $this->assertEquals($item['status'], $dto->getStatus());
    }

    public function testDtoToArray()
    {
        $dto = new CreditCardDTO();
        $dto->setName('Test');
        $dto->setLimit(1000);
        $dto->setDueDate(16);
        $dto->setClosingDay(1);

        $array = $this->resource->dtoToArray($dto);

        $this->assertEquals($dto->getName(), $array['name']);
        $this->assertEquals($dto->getLimit(), $array['limit']);
        $this->assertEquals($dto->getDueDate(), $array['due_date']);
        $this->assertEquals($dto->getClosingDay(), $array['closing_day']);
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
        $dto->setTotalValueSpending(15);
        $dto->setNextInvoiceValue(10);

        $vo = $this->resource->dtoToVo($dto);

        $this->assertEquals($dto->getId(), $vo->id);
        $this->assertEquals($dto->getName(), $vo->name);
        $this->assertEquals($dto->getLimit(), $vo->limit);
        $this->assertEquals($dto->getDueDate(), $vo->dueDate);
        $this->assertEquals($dto->getClosingDay(), $vo->closingDay);
        $this->assertEquals($dto->getCreatedAt(), $vo->createdAt);
        $this->assertEquals($dto->getUpdatedAt(), $vo->updatedAt);
        $this->assertEquals($dto->getTotalValueSpending(), $vo->totalValueSpending);
        $this->assertEquals($dto->getNextInvoiceValue(), $vo->nextInvoiceValue);
    }

    public function testTransactionToInvoiceDTO()
    {
        $item = [];
        $item['id'] = 1;
        $item['credit_card_id'] = 1;
        $item['name'] = 'Test';
        $item['value'] = 1000;
        $item['next_installment'] = '2021-11';
        $item['installments'] = 1;

        $dto = $this->resource->transactionToInvoiceDTO($item);

        $this->assertEquals($item['id'], $dto->getId());
        $this->assertEquals($item['credit_card_id'], $dto->getCountId());
        $this->assertEquals($item['name'], $dto->getDescription());
        $this->assertEquals($item['value'], $dto->getValue());
        $this->assertEquals($item['next_installment'], $dto->getNextInstallment());
        $this->assertEquals(11, $dto->getNextInstallmentMonth());
        $this->assertEquals($item['installments'], $dto->getInstallments());
    }
}
