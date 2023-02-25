<?php

namespace App\Repositories;

use App\Models\Teste;
use Illuminate\Http\Request;

class TesteRepositoryEloquent implements TesteRepositoryInterface
{
    private Teste $teste;

    public function __construct(Teste $teste)
    {
        $this->teste = $teste;
    }

    public function indexTeste()
    {
        return $this->teste->select()->get();
    }

    public function getTeste(int $id)
    {
        return $this->teste->find($id);
    }

    public function postTeste(Request $request)
    {
        //O nome do campo no jsom tem que ser exatamente igual ao da coluna no db
        return $this->teste->create($request->all());
    }

    public function putTeste(int $id, Request $request)
    {
        //No put ele só retorna 1 ou 0, para informar se foi atualizado ou não
        return $this->teste->where('id', $id)->update(($request->all()));
    }

    public function deleteTeste(int $id)
    {
        $teste = $this->teste->find($id);
        return $teste->delete();
    }
}
