<?php

namespace Tests\backend\Unit\Resource\Log;

use App\DTO\Log\AccessLogDTO;
use App\Resources\Log\AccessLogResource;
use App\VO\Log\AccessLogVO;
use Tests\backend\Falcon9;

class AccessLogResourceUnitTest extends Falcon9
{
    private AccessLogResource $accessLogResource;
    private AccessLogDTO $accessLogDTO;

    public function setUp(): void
    {
        parent::setUp();
        $this->accessLogResource = app(AccessLogResource::class);
        $this->accessLogDTO = new AccessLogDTO(
            1,
            2,
            '192.168.10.10',
            '111',
            'abc',
            0,
            'test',
            1,
            '2020-01-01 00:00:00'
        );
    }

    public function testArrayDtoToVoItensWithNullItem()
    {
        $this->assertEquals(array(), $this->accessLogResource->arrayDtoToVoItens(null));
    }

    public function testArrayDtoToVoItens()
    {
        $dtoTwo = new AccessLogDTO(
            2,
            3,
            '198.122.22.110',
            '222',
            'deg',
            1,
            'test',
            1,
            '2020-01-01 00:00:00'
        );

        $item = $this->accessLogResource->arrayDtoToVoItens([$this->accessLogDTO, $dtoTwo]);

        $this->assertIsArray($item);
        $this->assertCount(2, $item);
        $this->assertInstanceOf(AccessLogVO::class, $item[0]);
        $this->assertInstanceOf(AccessLogVO::class, $item[1]);
    }

    public function testArrayToDtoItensWithNullItem()
    {
        $this->assertEquals(array(), $this->accessLogResource->arrayToDtoItens(null));
    }

    public function testArrayToDtoItens()
    {
        $item = $this->accessLogResource->arrayToDtoItens([
            [
                'id' => 1,
                'user_id' => 2,
                'user_ip' => '193.22.33.44',
                'account_group' => '111',
                'user_agent' => 'sssss',
                'logged' => 0,
                'comments' => 'test',
                'tenant_id' => '2',
                'created_at' => '2021-01-01 00:00:00',
            ],
            [
                'id' => 5,
                'user_id' => 6,
                'user_ip' => '193.11.22.45',
                'account_group' => '222',
                'user_agent' => 'ppppppp',
                'logged' => 1,
                'comments' => 'test1',
                'tenant_id' => '1',
                'created_at' => '2023-01-01 00:00:00',
            ]
        ]);

        $this->assertIsArray($item);
        $this->assertCount(2, $item);
        $this->assertInstanceOf(AccessLogDTO::class, $item[0]);
        $this->assertInstanceOf(AccessLogDTO::class, $item[1]);
    }

    public function testDtoToArray()
    {
        $item = $this->accessLogResource->dtoToArray($this->accessLogDTO);

        $this->assertIsArray($item);
        $this->assertCount(9, $item);
        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('user_id', $item);
        $this->assertArrayHasKey('user_ip', $item);
        $this->assertArrayHasKey('account_group', $item);
        $this->assertArrayHasKey('user_agent', $item);
        $this->assertArrayHasKey('logged', $item);
        $this->assertArrayHasKey('comments', $item);
        $this->assertArrayHasKey('created_at', $item);
    }
}