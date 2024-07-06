<?php

namespace Tests\backend\Unit\Resource;

use App\Resources\FutureGainResource;
use Tests\backend\Falcon9;

class FutureGainResourceUnitTest extends Falcon9
{
    private FutureGainResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = app(FutureGainResource::class);
    }

    public function testArrayToDto()
    {
        $item = [
            'id' => 1,
            'wallet_id' => 1,
            'description' => 'Test',
            'name' => 'TestCountName',
            'forecast' => '2021-01-01',
            'amount' => 100,
            'installments' => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ];
        $dto = $this->resource->arrayToDto($item);

        $this->assertEquals($item['id'], $dto->getId());
        $this->assertEquals($item['wallet_id'], $dto->getWalletId());
        $this->assertEquals($item['description'], $dto->getDescription());
        $this->assertEquals($item['name'], $dto->getWalletName());
        $this->assertEquals($item['forecast'], $dto->getForecast());
        $this->assertEquals($item['amount'], $dto->getAmount());
        $this->assertEquals($item['installments'], $dto->getInstallments());
        $this->assertEquals($item['created_at'], $dto->getCreatedAt());
        $this->assertEquals($item['updated_at'], $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $item = [
            'id' => 1,
            'wallet_id' => 1,
            'description' => 'Test',
            'name' => 'TestCountName',
            'forecast' => '2021-01-01',
            'amount' => 100,
            'installments' => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ];
        $dto = $this->resource->arrayToDto($item);
        $array = $this->resource->dtoToArray($dto);

        $this->assertEquals($item['id'], $array['id']);
        $this->assertEquals($item['wallet_id'], $array['wallet_id']);
        $this->assertEquals($item['description'], $array['description']);
        $this->assertEquals($item['forecast'], $array['forecast']);
        $this->assertEquals($item['amount'], $array['amount']);
        $this->assertEquals($item['installments'], $array['installments']);
        $this->assertEquals($item['created_at'], $array['created_at']);
        $this->assertEquals($item['updated_at'], $array['updated_at']);
    }

    public function testDtoToVo()
    {
        $item = [
            'id' => 1,
            'wallet_id' => 1,
            'name' => 'TestCountName',
            'description' => 'Test',
            'forecast' => '2021-01-01',
            'amount' => 100,
            'installments' => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ];
        $dto = $this->resource->arrayToDto($item);
        $vo = $this->resource->dtoToVo($dto);

        $this->assertEquals($item['id'], $vo->id);
        $this->assertEquals($item['wallet_id'], $vo->walletId);
        $this->assertEquals($item['name'], $vo->walletName);
        $this->assertEquals($item['description'], $vo->description);
        $this->assertEquals($item['forecast'], $vo->forecast);
        $this->assertEquals($item['amount'], $vo->amount);
        $this->assertEquals($item['installments'], $vo->installments);
        $this->assertEquals($item['created_at'], $vo->createdAt);
        $this->assertEquals($item['updated_at'], $vo->updatedAt);
    }

    public function testFutureGainToInvoiceDTO()
    {
        $item = [
            'id' => 1,
            'wallet_id' => 1,
            'name' => 'TestCountName',
            'description' => 'Test',
            'forecast' => '2021-01-01',
            'amount' => 100,
            'installments' => 1,
        ];
        $dto = $this->resource->arrayToDto($item);
        $invoiceDTO = $this->resource->futureGainToInvoiceDTO($dto);

        $this->assertEquals($item['id'], $invoiceDTO->getId());
        $this->assertEquals($item['wallet_id'], $invoiceDTO->getCountId());
        $this->assertEquals($item['name'], $invoiceDTO->getCountName());
        $this->assertEquals($item['description'], $invoiceDTO->getDescription());
        $this->assertEquals($item['forecast'], $invoiceDTO->getNextInstallment());
        $this->assertEquals($item['amount'], $invoiceDTO->getValue());
        $this->assertEquals($item['installments'], $invoiceDTO->getInstallments());
    }
}
