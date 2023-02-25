<?php

namespace App\Http\Controllers;

use App\BO\TesteBO;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class testeController extends BasicController
{
    private TesteBO $bo;

    public function __construct(TesteBO $bo)
    {
        $this->bo = $bo;
    }

    public function indexTeste()
    {
        $teste = $this->bo->apiIndex();
        if (count($teste) == 0) {
            return response()->json(array(), ResponseAlias::HTTP_OK);
        }
        return response()->json($teste, ResponseAlias::HTTP_OK);
    }

    public function getTeste(int $id)
    {
        //exemplo de responses
        try {
            $teste = $this->bo->apiGet($id);
            if (!$teste) {
                return response()->json('Registro não encontrado!',ResponseAlias::HTTP_NOT_FOUND);
            }
            return response()->json($teste, ResponseAlias::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json('Erro ao se conectar com o banco de dados', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function postTeste(Request $request)
    {
        //Exemplo de validador
        //Criar uma classe para isso
        $validate = Validator::make(
            //quais dados vai validar
            $request->all(),
            //array de regras
            array('name' => 'max:2'),
            //tradução da mensagem
            array('max' => 'O :attribute não pode ser maior que :max caracteres!')
        );
        if ($validate->fails()) {
            return response()->json($validate->errors(), ResponseAlias::HTTP_BAD_REQUEST);
        }
        return $this->bo->apiInsert($request);
    }

    public function putTeste(int $id, Request $request)
    {
        return $this->bo->apiUpdate($id, $request);
    }

    public function deleteTeste(int $id)
    {
        return $this->bo->apiDelete($id);
    }
}
