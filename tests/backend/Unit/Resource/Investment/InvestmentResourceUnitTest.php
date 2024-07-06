<?php

namespace Tests\backend\Unit\Resource\Investment;

use App\DTO\Investment\InvestmentDTO;
use App\Resources\Investment\InvestmentResource;
use Tests\backend\Falcon9;

class InvestmentResourceUnitTest extends Falcon9
{
    public function testArrayToDTO()
    {
        $array = [
            'id' => 1,
            'credit_card_id' => 1,
            'description' => 'Teste',
            'type' => 1,
            'amount' => 1,
            'liquidity' => 1,
            'profitability' => 1,
            'created_at' => '2021-01-01',
            'updated_at' => '2021-01-01',
        ];

        $resource = new InvestmentResource();
        $dto = $resource->arrayToDto($array);

        $this->assertEquals($array['id'], $dto->getId());
        $this->assertEquals($array['credit_card_id'], $dto->getCreditCardId());
        $this->assertEquals($array['description'], $dto->getDescription());
        $this->assertEquals($array['type'], $dto->getType());
        $this->assertEquals($array['amount'], $dto->getAmount());
        $this->assertEquals($array['liquidity'], $dto->getLiquidity());
        $this->assertEquals($array['profitability'], $dto->getProfitability());
        $this->assertEquals($array['created_at'], $dto->getCreatedAt());
        $this->assertEquals($array['updated_at'], $dto->getUpdatedAt());
    }

    public function testDtoToArray()
    {
        $dto = new InvestmentDTO(
            1,
            1,
            'Teste',
            1,
            1,
            1,
            1,
            '2021-01-01',
            '2021-01-01'
        );

        $resource = new InvestmentResource();
        $array = $resource->dtoToArray($dto);

        $this->assertEquals($dto->getCreditCardId(), $array['credit_card_id']);
        $this->assertEquals($dto->getDescription(), $array['description']);
        $this->assertEquals($dto->getType(), $array['type']);
        $this->assertEquals($dto->getAmount(), $array['amount']);
        $this->assertEquals($dto->getLiquidity(), $array['liquidity']);
        $this->assertEquals($dto->getProfitability(), $array['profitability']);
    }

    public function testDtoToVo()
    {
        $dto = new InvestmentDTO(
            1,
            1,
            'Teste',
            1,
            1,
            1,
            1,
            '2021-01-01',
            '2021-01-01'
        );

        $resource = new InvestmentResource();
        $vo = $resource->dtoToVo($dto);

        $this->assertEquals($dto->getId(), $vo->id);
        $this->assertEquals($dto->getCreditCardId(), $vo->creditCardId);
        $this->assertEquals($dto->getDescription(), $vo->description);
        $this->assertEquals($dto->getType(), $vo->type);
        $this->assertEquals($dto->getAmount(), $vo->amount);
        $this->assertEquals($dto->getLiquidity(), $vo->liquidity);
        $this->assertEquals($dto->getProfitability(), $vo->profitability);
        $this->assertEquals($dto->getCreatedAt(), $vo->createdAt);
        $this->assertEquals($dto->getUpdatedAt(), $vo->updatedAt);
    }
}
