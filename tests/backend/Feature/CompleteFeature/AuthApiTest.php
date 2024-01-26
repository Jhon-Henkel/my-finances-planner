<?php

namespace Tests\backend\Feature\CompleteFeature;

use App\Enums\StatusEnum;
use App\Models\User;
use Tests\backend\Falcon9Feature;

class AuthApiTest extends Falcon9Feature
{
    public function testWithoutTokenInRequest()
    {
        $response = $this->get('/api/wallet');

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('Tokens obrigatórios ausentes ou inválidos!', json_decode($response->getContent()));
    }

    public function testWithOnlyMfpTokenInRequest()
    {
        $headers = $this->apiHeaders;
        unset($headers['MFP-TOKEN']);

        $response = $this->get('/api/wallet', $headers);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('Tokens obrigatórios ausentes ou inválidos!', json_decode($response->getContent()));
    }

    public function testWithoutUserTokenInRequest()
    {
        $headers = $this->apiHeaders;
        unset($headers['X-MFP-USER-TOKEN']);

        $response = $this->get('/api/wallet', $headers);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('Tokens obrigatórios ausentes ou inválidos!', json_decode($response->getContent()));
    }

    public function testValidRequest()
    {
        $response = $this->get('/api/wallet', $this->apiHeaders);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsArray(json_decode($response->getContent()));
    }

    public function testWithInactiveUser()
    {
        User::query()->where('email', $this->user->email)->update(['status' => StatusEnum::Inactive->value]);

        $headers = $this->apiHeaders;

        $response = $this->get('/api/wallet', $headers);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('Tokens obrigatórios ausentes ou inválidos!', json_decode($response->getContent()));

    }
}