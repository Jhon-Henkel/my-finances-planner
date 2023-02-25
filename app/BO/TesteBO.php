<?php

namespace App\BO;

use App\DAO\TesteDAO;
use App\DAO\TesteDaoContract;
use Illuminate\Http\Request;

class TesteBO
{
    private TesteDAO $dao;

    public function __construct(TesteDaoContract $testeRepository)
    {
        $this->dao = $testeRepository;
    }

    public function indexTeste()
    {
        return $this->dao->indexTeste();
    }

    public function getTeste(int $id)
    {
        return $this->dao->getModel($id);
    }

    public function postTeste(Request $request)
    {
        return $this->dao->postTeste($request);
    }

    public function putTeste(int $id, Request $request)
    {
        return $this->dao->putTeste($id, $request);
    }

    public function deleteTeste(int $id)
    {
        return $this->dao->deleteTeste($id);
    }
}
