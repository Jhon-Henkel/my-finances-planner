<?php

namespace App\Http\Controllers;

use App\Services\CronService;
use App\Tools\RequestTools;

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

    public function resetDatabaseDemo(): void
    {
        if (! RequestTools::isApplicationInDemoMode()) {
            $message = 'Modo demonstração não está ativo.';
            die($message);
        }
        $deletedTables = $this->getService()->truncateDatabaseDemoTables();
        if (! $deletedTables) {
            $message = 'Não foi possível limpar as tabelas.';
            die($message);
        }
        $insertedTables = $this->getService()->insertDatabaseDemoData();
        if (! $insertedTables) {
            $message = 'Não foi possível inserir os dados nas tabelas.';
            die($message);
        }
    }
}