<?php

namespace Tests\backend\Unit\Http\Response;

use App\Http\Response\ApiResponse;
use Tests\backend\Falcon9;

class ApiResponseUnitTest extends Falcon9
{
    public function testResponseError()
    {
        $response = ApiResponse::responseError('Error', 500);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Error', $response->getData()->message);
    }
}
