<?php

namespace App\DAO;

use App\Models\Teste;
use Illuminate\Http\Request;

class TesteDAO implements TesteDaoContract
{
    private Teste $model;

    public function __construct(Teste $model)
    {
        $this->model = $model;
    }

    public function indexTeste()
    {
        return $this->model->select()->get();
    }

    public function getModel(int $id)
    {
        return $this->model->find($id);
    }

    public function postTeste(Request $request)
    {
        //O nome do campo no jsom tem que ser exatamente igual ao da coluna no db
        return $this->model->create($request->all());
    }

    public function putTeste(int $id, Request $request)
    {
        //No put ele só retorna 1 ou 0, para informar se foi atualizado ou não
        return $this->model->where('id', $id)->update(($request->all()));
    }

    public function deleteTeste(int $id)
    {
        $teste = $this->model->find($id);
        return $teste->delete();
    }
}
