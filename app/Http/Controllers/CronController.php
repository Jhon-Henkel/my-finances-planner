<?php

namespace App\Http\Controllers;

use App\Services\CronService;
use App\Tools\RequestTools;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CronController
{
    private CronService $service;

    public function __construct()
    {
        $this->service = app(CronService::class);
    }

    protected function getService()
    {
        return $this->service;
    }

    public function resetDatabaseDemo(): JsonResponse
    {
        if (! RequestTools::isApplicationInDemoMode()) {
            $message = 'Modo demonstração não está ativo.';
            return response()->json($message, ResponseAlias::HTTP_BAD_REQUEST);
        }
        $deletedTables = $this->getService()->truncateDatabaseDemoTables();
        if (! $deletedTables) {
            $message = 'Não foi possível limpar as tabelas.';
            return response()->json($message, ResponseAlias::HTTP_BAD_REQUEST);
        }
        $insertedTables = $this->getService()->insertDatabaseDemoData();
        if (! $insertedTables) {
            $message = 'Não foi possível inserir os dados nas tabelas.';
            return response()->json($message, ResponseAlias::HTTP_BAD_REQUEST);
        }
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}