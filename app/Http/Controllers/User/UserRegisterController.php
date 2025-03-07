<?php

namespace App\Http\Controllers\User;

use App\DTO\User\UserRegisterDTO;
use App\Exceptions\NotImplementedException;
use App\Http\Controllers\BasicController;
use App\Resources\UserResource;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Queue\QueueMessagesService;
use App\Services\User\UserRegisterService;
use App\Tools\Response\ResponseApi;
use App\Tools\Validator\MfpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserRegisterController extends BasicController
{
    public function __construct(
        private readonly UserRegisterService $service,
        private readonly QueueMessagesService $queueMessagesService,
        private readonly DatabaseConnectionService $databaseConnectionService,
    ) {
    }

    protected function rulesInsert(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'confirmPassword' => 'required|string',
        ];
    }

    protected function rulesUpdate(): array
    {
        throw new NotImplementedException();
    }

    protected function getService(): UserRegisterService
    {
        return $this->service;
    }

    protected function getResource(): UserResource
    {
        throw new NotImplementedException();
    }

    /**
     * Responsável por:
     *  - Validar os dados
     *  - Colocar a etapa 1 na fila
     */
    public function registerStepZero(Request $request): JsonResponse
    {
        $this->databaseConnectionService->setMasterConnection();
        $data = $request->json()->all();
        MfpValidator::validateRequest($request, $this->rulesInsert());
        $this->queueMessagesService->putMessageUserRegisterStepOne($data);
        return ResponseApi::renderCreated();
    }

    /**
     * Responsável por:
     *  - Validar os dados
     *  - Criar o Banco
     *  - Criar o tenant
     *  - Criar o usuário
     *  - Colocar a etapa 2 na fila
     */
    public function registerStepOne(Request $request): JsonResponse
    {
        $this->databaseConnectionService->setMasterConnection();
        $dataDecrypted = Crypt::decryptString($request->json()->all()[0]);
        $dataDecoded = json_decode($dataDecrypted, true);
        MfpValidator::validateArrayData($dataDecoded, $this->rulesInsert());
        $this->getService()->registerUserStepOne(new UserRegisterDTO($dataDecoded));
        return ResponseApi::renderCreated();
    }

    /**
     * Responsável por:
     *  - Validar os dados
     *  - Rodar as migrations
     *  - Enviar e-mail de ativação de conta para o usuário
     */
    public function registerStepTwo(Request $request): JsonResponse
    {
        $this->databaseConnectionService->setMasterConnection();
        $dataDecrypted = Crypt::decryptString($request->json()->all()[0]);
        $dataDecoded = json_decode($dataDecrypted, true);
        $this->getService()->registerUserStepTwo($dataDecoded['userId']);
        return ResponseApi::renderOk();
    }

    /**
     * Responsável por:
     *  - Ativar o usuário
     */
    public function registerStepThree(string $hash): JsonResponse
    {
        $this->databaseConnectionService->setMasterConnection();
        $this->getService()->registerUserStepThree($hash);
        return ResponseApi::renderOk();
    }
}
