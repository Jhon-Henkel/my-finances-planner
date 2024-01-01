<?php

namespace Tests\backend\Unit\Http\Response;

use App\Http\Response\ResponseError;
use Tests\backend\Falcon9;

class ResponseErrorUnitTest extends Falcon9
{
    public function testResponseError()
    {
        $response = ResponseError::responseError('Error', 500);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Error', $response->getData()->message);
    }
}