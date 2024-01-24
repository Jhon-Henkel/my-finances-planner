<?php

namespace Tests\backend\Feature\CompleteFeature;

use App\Models\WalletModel;
use Illuminate\Support\Facades\DB;
use Tests\backend\Falcon9Feature;
use Tests\backend\Trait\UserTrait;

class MultiTenantFeatureTest extends Falcon9Feature
{
    use UserTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->removeWallets();
    }

    protected function tearDown(): void
    {
        $this->removeWallets();
        parent::tearDown();
    }

    protected function removeWallets(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WalletModel::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    protected function insertWallet(int $tenantId): array
    {
        $walletFirstUser = WalletModel::factory(['tenant_id' => $tenantId])->create();
        $walletFirstUser->save();
        return $walletFirstUser->toArray();
    }

    protected function setServerHttpMfpUserToken(string $value): void
    {
        unset($_SERVER['HTTP_X_MFP_USER_TOKEN']);
        $_SERVER['HTTP_X_MFP_USER_TOKEN'] = $value;
    }

    public function testListWalletsTwoUsersDifferent()
    {
        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $walletOneInserted = $this->insertWallet($this->user->tenant_id);

        $secondUser = $this->registerSecondUser();
        $headerSecondUser = $this->makeHeadersSecondUser($secondUser);
        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $walletTwoInserted = $this->insertWallet($secondUser->tenant_id);

        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $walletOneFound = $this->withHeaders($this->apiHeaders)->getJson('/api/wallet')->json();

        $this->assertCount(1, $walletOneFound);
        $this->assertEquals($walletOneInserted['id'], $walletOneFound[0]['id']);
        $this->assertEquals($walletOneInserted['name'], $walletOneFound[0]['name']);
        $this->assertEquals($walletOneInserted['type'], $walletOneFound[0]['type']);
        $this->assertEquals($walletOneInserted['amount'], $walletOneFound[0]['amount']);
        $this->assertEquals($walletOneInserted['tenant_id'], $this->user->tenant_id);

        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $walletTwoFound = $this->withHeaders($headerSecondUser)->getJson('/api/wallet')->json();

        $this->assertCount(1, $walletTwoFound);
        $this->assertEquals($walletTwoInserted['id'], $walletTwoFound[0]['id']);
        $this->assertEquals($walletTwoInserted['name'], $walletTwoFound[0]['name']);
        $this->assertEquals($walletTwoInserted['type'], $walletTwoFound[0]['type']);
        $this->assertEquals($walletTwoInserted['amount'], $walletTwoFound[0]['amount']);
        $this->assertEquals($walletTwoInserted['tenant_id'], $secondUser->tenant_id);
    }

    public function testGetAnotherUserWallet()
    {
        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $walletOneInserted = $this->insertWallet($this->user->tenant_id);

        $secondUser = $this->registerSecondUser();
        $headerSecondUser = $this->makeHeadersSecondUser($secondUser);
        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $walletTwoInserted = $this->insertWallet($secondUser->tenant_id);

        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $walletOne = $this->withHeaders($this->apiHeaders)->getJson('/api/wallet/' . $walletTwoInserted['id'])->json();

        $this->assertEquals('Registro não encontrado!', $walletOne);

        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $walletTwo = $this->withHeaders($headerSecondUser)->getJson('/api/wallet/' . $walletOneInserted['id'])->json();

        $this->assertEquals('Registro não encontrado!', $walletTwo);
    }

    public function testUpdateAnotherUserWallet()
    {
        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $walletOneInserted = $this->insertWallet($this->user->tenant_id);

        $secondUser = $this->registerSecondUser();
        $headerSecondUser = $this->makeHeadersSecondUser($secondUser);
        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $walletTwoInserted = $this->insertWallet($secondUser->tenant_id);

        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $this->withHeaders($this->apiHeaders)->putJson('/api/wallet/' . $walletTwoInserted['id'], $walletOneInserted)->json();

        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $this->withHeaders($headerSecondUser)->putJson('/api/wallet/' . $walletOneInserted['id'], $walletTwoInserted)->json();

        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $walletOne = $this->withHeaders($this->apiHeaders)->getJson('/api/wallet/' . $walletOneInserted['id'])->json();

        $this->assertEquals($walletOneInserted['name'], $walletOne['name']);

        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $walletTwoFound = $this->withHeaders($headerSecondUser)->getJson('/api/wallet/' . $walletTwoInserted['id'])->json();

        $this->assertEquals($walletTwoInserted['name'], $walletTwoFound['name']);
    }

    public function testDeleteAnotherUserWallet()
    {
        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $walletOneInserted = $this->insertWallet($this->user->tenant_id);

        $secondUser = $this->registerSecondUser();
        $headerSecondUser = $this->makeHeadersSecondUser($secondUser);
        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $walletTwoInserted = $this->insertWallet($secondUser->tenant_id);

        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $this->withHeaders($this->apiHeaders)->deleteJson('/api/wallet/' . $walletTwoInserted['id']);

        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $this->withHeaders($headerSecondUser)->deleteJson('/api/wallet/' . $walletOneInserted['id']);

        $this->setServerHttpMfpUserToken($this->apiHeaders['X-MFP-USER-TOKEN']);
        $walletOne = $this->withHeaders($this->apiHeaders)->getJson('/api/wallet/' . $walletOneInserted['id'])->json();

        $this->assertEquals($walletOneInserted['name'], $walletOne['name']);

        $this->setServerHttpMfpUserToken($headerSecondUser['X-MFP-USER-TOKEN']);
        $walletTwo = $this->withHeaders($headerSecondUser)->getJson('/api/wallet/' . $walletTwoInserted['id'])->json();

        $this->assertEquals($walletTwoInserted['name'], $walletTwo['name']);
    }
}