<?php

namespace Tests\backend\Feature\CompleteFeature;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tests\backend\Falcon9Feature;

class ConfigurationsFeatureTest extends Falcon9Feature
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        DB::insert(
            'INSERT INTO configurations (name, value) VALUES (?, ?)',
            ['name_inserted_by_PHPUnit', 'value inserted by PHPUnit']
        );
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function testGetConfig()
    {
        $response = $this->getJson('/api/configurations/name_inserted_by_PHPUnit', $this->makeHeaders());

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['name', 'value']);
        $response->assertJson(['name' => 'name_inserted_by_PHPUnit', 'value' => 'value inserted by PHPUnit']);
    }

    public function testUpdateConfig()
    {
        $response = $this->putJson(
            '/api/configurations/name_inserted_by_PHPUnit',
            ['value' => 'value updated by PHPUnit'],
            $this->makeHeaders()
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['name', 'value']);
        $response->assertJson(['name' => 'name_inserted_by_PHPUnit', 'value' => 'value updated by PHPUnit']);
    }
}
