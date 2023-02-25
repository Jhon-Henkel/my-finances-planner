<?php

namespace App\Services;

use App\Repositories\TesteRepositoryEloquent;
use App\Repositories\TesteRepositoryInterface;
use Illuminate\Http\Request;

class TesteService
{
    private TesteRepositoryEloquent $testeRepository;

    public function __construct(TesteRepositoryInterface $testeRepository)
    {
        $this->testeRepository = $testeRepository;
    }

    public function indexTeste()
    {
        return $this->testeRepository->indexTeste();
    }

    public function getTeste(int $id)
    {
        return $this->testeRepository->getTeste($id);
    }

    public function postTeste(Request $request)
    {
        return $this->testeRepository->postTeste($request);
    }

    public function putTeste(int $id, Request $request)
    {
        return $this->testeRepository->putTeste($id, $request);
    }

    public function deleteTeste(int $id)
    {
        return $this->testeRepository->deleteTeste($id);
    }
}
