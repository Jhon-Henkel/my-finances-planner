<?php

namespace Tests\Unit\Resource;

use App\DTO\MonthlyClosingDTO;
use Tests\TestCase;

class MonthlyClosingResourceUnitTest extends TestCase
{
    private $monthlyClosingResource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->monthlyClosingResource = $this->app->make('App\Resources\MonthlyClosingResource');
    }

    public function testArrayToDto()
    {
        $item = [
            'id' => 1,
            'predicted_earnings' => 1000.00,
            'predicted_expenses' => 500.00,
            'real_earnings' => 1000.00,
            'real_expenses' => 500.00,
            'balance' => 500.00,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ];

        $dto = $this->monthlyClosingResource->arrayToDto($item);

        $this->assertEquals($item['id'], $dto->getId());
        $this->assertEquals($item['predicted_earnings'], $dto->getPredictedEarnings());
        $this->assertEquals($item['predicted_expenses'], $dto->getPredictedExpenses());
        $this->assertEquals($item['real_earnings'], $dto->getRealEarnings());
        $this->assertEquals($item['real_expenses'], $dto->getRealExpenses());
        $this->assertEquals($item['balance'], $dto->getBalance());
        $this->assertEquals($item['created_at'], $dto->getCreatedAt());
        $this->assertEquals($item['updated_at'], $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $dto = new MonthlyClosingDTO(
            1,
            1000.00,
            500.00,
            1000.00,
            500.00,
            500.00,
            '2021-01-01 00:00:00',
            '2021-01-01 00:00:00'
        );

        $item = $this->monthlyClosingResource->dtoToArray($dto);

        $this->assertEquals($dto->getId(), $item['id']);
        $this->assertEquals($dto->getPredictedEarnings(), $item['predicted_earnings']);
        $this->assertEquals($dto->getPredictedExpenses(), $item['predicted_expenses']);
        $this->assertEquals($dto->getRealEarnings(), $item['real_earnings']);
        $this->assertEquals($dto->getRealExpenses(), $item['real_expenses']);
        $this->assertEquals($dto->getBalance(), $item['balance']);
        $this->assertEquals($dto->getCreatedAt(), $item['created_at']);
        $this->assertEquals($dto->getUpdatedAt(), $item['updated_at']);
    }

    public function testDtoToVo()
    {
        $dto = new MonthlyClosingDTO(
            1,
            1000.00,
            500.00,
            1000.00,
            500.00,
            500.00,
            '2021-01-01 00:00:00',
            '2021-01-01 00:00:00'
        );

        $vo = $this->monthlyClosingResource->dtoToVo($dto);

        $this->assertEquals($dto->getId(), $vo->id);
        $this->assertEquals($dto->getPredictedEarnings(), $vo->predictedEarnings);
        $this->assertEquals($dto->getPredictedExpenses(), $vo->predictedExpenses);
        $this->assertEquals($dto->getRealEarnings(), $vo->realEarnings);
        $this->assertEquals($dto->getRealExpenses(), $vo->realExpenses);
        $this->assertEquals($dto->getBalance(), $vo->balance);
        $this->assertEquals($dto->getCreatedAt(), $vo->createdAt);
        $this->assertEquals($dto->getUpdatedAt(), $vo->updatedAt);
    }
}