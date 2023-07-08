<?php

namespace Tests\Unit\Http\Response;

use App\Http\Response\ResponseError;
use Tests\Falcon9;

class ResponseErrorUnitTest extends Falcon9
{
    public function testResponseError()
    {
        $response = ResponseError::responseError('Error', 500);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Error', $response->getData()->message);
    }
}