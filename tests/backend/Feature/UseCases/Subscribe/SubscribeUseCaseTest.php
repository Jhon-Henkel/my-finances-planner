<?php

namespace Tests\backend\Feature\UseCases\Subscribe;

use App\Enums\Response\StatusCodeEnum;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Subscription\SubscriptionService;
use Tests\backend\Falcon9Feature;
use Tests\backend\Stubs\PaymentMethod\PayPalServiceStub;

class SubscribeUseCaseTest extends Falcon9Feature
{
    private array $headers;
    private string $baseUrl = '/api/subscription/';

    protected function setUp(): void
    {
        parent::setUp();
        $userLoginData = $this->createNewUser();
        $login = $this->postJson('/auth', $userLoginData);
        $this->headers = $this->headerWithoutUser;
        $this->headers['X-MFP-USER-TOKEN'] = 'Bearer ' . $login->json('token');
        $connection = new DatabaseConnectionService();
        $connection->setMasterConnection();
    }

    public function testSubscriptionFlow()
    {
        $stub = new PayPalServiceStub($this->faker->uuid);

        $subscriptionServiceMock = $this->mock(SubscriptionService::class)->makePartial();
        $subscriptionServiceMock->shouldAllowMockingProtectedMethods();
        $subscriptionServiceMock->shouldReceive('getPaymentMethod')->andReturn($stub);
        $this->app->instance(SubscriptionService::class, $subscriptionServiceMock);

        // Subscribe
        $response = $this->postJson($this->baseUrl . 'subscribe', [], $this->headers);

        $connection = new DatabaseConnectionService();
        $connection->setMasterConnection();

        $this->assertEquals(StatusCodeEnum::HttpOk->value, $response->getStatusCode(), 'Fail at subscribe');
        $this->assertDatabaseHas('users', [
            'subscription_id' => $stub->subscriptionId,
        ]);

        // Get subscription
        $response = $this->getJson($this->baseUrl . 'status', $this->headers);

        $this->assertEquals(StatusCodeEnum::HttpOk->value, $response->getStatusCode(), 'Fail at get subscription');
        $response->assertJson([
            'status' => 'ACTIVE',
            'subscriptionId' => $stub->subscriptionId,
        ]);

        // Cancel subscription
        $response = $this->postJson($this->baseUrl . 'cancel', ['reason' => 'Canceling the subscription'], $this->headers);

        $connection->setMasterConnection();

        $this->assertEquals(StatusCodeEnum::HttpOk->value, $response->getStatusCode(), 'Fail at cancel subscription');
        $this->assertDatabaseMissing('users', [
            'subscription_id' => $stub->subscriptionId,
        ]);
    }
}
