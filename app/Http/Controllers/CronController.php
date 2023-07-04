<?php

namespace App\Http\Controllers;

use App\Services\CronService;
use App\Tools\DemoApplicationTools;
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
        if (! DemoApplicationTools::truncateDatabaseDemoTables()) {
            $message = 'Não foi possível limpar as tabelas.';
            die($message);
        }
        if (! DemoApplicationTools::insertDatabaseDemoData()) {
            $message = 'Não foi possível inserir os dados nas tabelas.';
            die($message);
        }
    }
}