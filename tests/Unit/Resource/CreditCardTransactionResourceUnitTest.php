<?php

namespace Tests\Unit\Resource;

use App\DTO\CreditCardTransactionDTO;
use App\Resources\CreditCardTransactionResource;
use Tests\Falcon9;

class CreditCardTransactionResourceUnitTest extends Falcon9
{
    private CreditCardTransactionResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = app(CreditCardTransactionResource::class);
    }

    public function testArrayToDto()
    {
        $item = [
            'id' => 1,
            'name' => 'Test',
            'value' => 100,
            'installments' => 1,
            'credit_card_id' => 1,
            'next_installment' => '2023-5',
            'created_at' => '2021-01-01',
            'updated_at' => '2022-08-09',
        ];
        $dto = $this->resource->arrayToDto($item);

        $this->assertEquals($item['id'], $dto->getId());
        $this->assertEquals($item['name'], $dto->getName());
        $this->assertEquals($item['value'], $dto->getValue());
        $this->assertEquals($item['installments'], $dto->getInstallments());
        $this->assertEquals($item['credit_card_id'], $dto->getCreditCardId());
        $this->assertEquals($item['next_installment'], $dto->getNextInstallment());
        $this->assertEquals($item['created_at'], $dto->getCreatedAt());
        $this->assertEquals($item['updated_at'], $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $dto = new CreditCardTransactionDTO();
        $dto->setName('Test');
        $dto->setValue(100);
        $dto->setInstallments(1);
        $dto->setCreditCardId(1);
        $dto->setNextInstallment('2023-5');
        $dto->setCreatedAt('2021-01-01');
        $dto->setUpdatedAt('2022-08-09');

        $array = $this->resource->dtoToArray($dto);

        $this->assertEquals($dto->getName(), $array['name']);
        $this->assertEquals($dto->getValue(), $array['value']);
        $this->assertEquals($dto->getInstallments(), $array['installments']);
        $this->assertEquals($dto->getCreditCardId(), $array['credit_card_id']);
        $this->assertEquals($dto->getNextInstallment(), $array['next_installment']);
    }

    public function testDtoToVo()
    {
        $dto = new CreditCardTransactionDTO();
        $dto->setId(1);
        $dto->setName('Test');
        $dto->setValue(100);
        $dto->setInstallments(1);
        $dto->setCreditCardId(1);
        $dto->setNextInstallment('2023-5');
        $dto->setCreatedAt('2021-01-01');
        $dto->setUpdatedAt('2022-08-09');

        $vo = $this->resource->dtoToVo($dto);

        $this->assertEquals($dto->getId(), $vo->id);
        $this->assertEquals($dto->getName(), $vo->name);
        $this->assertEquals($dto->getValue(), $vo->value);
        $this->assertEquals($dto->getInstallments(), $vo->installments);
        $this->assertEquals($dto->getCreditCardId(), $vo->creditCardId);
        $this->assertEquals($dto->getNextInstallment(), $vo->nextInstallment);
        $this->assertEquals($dto->getCreatedAt(), $vo->createdAt);
        $this->assertEquals($dto->getUpdatedAt(), $vo->updatedAt);
    }
}