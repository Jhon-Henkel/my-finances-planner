<?php

namespace Tests\Unit\Resource;

use App\DTO\WalletDTO;
use App\Resources\WalletResource;
use App\VO\WalletVO;
use Tests\TestCase;

class BasicResourceUnitTest extends TestCase
{
    private WalletResource $walletResource;

    public function setUp(): void
    {
        parent::setUp();
        $this->walletResource = app(WalletResource::class);
    }

    public function testArrayDtoToVoItensWithNullItem()
    {
        $this->assertEquals(array(), $this->walletResource->arrayDtoToVoItens(null));
    }

    public function testArrayDtoToVoItens()
    {
        $dtoOne = new WalletDTO();
        $dtoOne->setId(1);
        $dtoOne->setName('Wallet 1');
        $dtoOne->setType(1);
        $dtoOne->setAmount(100.00);
        $dtoOne->setCreatedAt('2021-01-01 00:00:00');
        $dtoOne->setUpdatedAt('2021-01-01 00:00:00');

        $dtoTwo = new WalletDTO();
        $dtoTwo->setId(2);
        $dtoTwo->setName('Wallet 2');
        $dtoTwo->setType(2);
        $dtoTwo->setAmount(200.00);
        $dtoTwo->setCreatedAt('2021-01-01 00:00:00');
        $dtoTwo->setUpdatedAt('2021-01-01 00:00:00');

        $item = $this->walletResource->arrayDtoToVoItens([$dtoOne, $dtoTwo]);

        $this->assertIsArray($item);
        $this->assertCount(2, $item);
        $this->assertInstanceOf(WalletVO::class, $item[0]);
        $this->assertInstanceOf(WalletVO::class, $item[1]);
    }

    public function testArrayToDtoItensWithNullItem()
    {
        $this->assertEquals(array(), $this->walletResource->arrayToDtoItens(null));
    }

    public function testArrayToDtoItens()
    {
        $item = $this->walletResource->arrayToDtoItens([
            [
                'id' => 1,
                'name' => 'Wallet 1',
                'type' => 1,
                'amount' => 100.00,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'name' => 'Wallet 2',
                'type' => 2,
                'amount' => 200.00,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ]
        ]);

        $this->assertIsArray($item);
        $this->assertCount(2, $item);
        $this->assertInstanceOf(WalletDTO::class, $item[0]);
        $this->assertInstanceOf(WalletDTO::class, $item[1]);
    }
}