<?php

namespace App\Http\Controllers;

use App\Tools\Validator\MfpValidator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

abstract class BasicController extends Controller
{
    abstract protected function rulesInsert(): array;
    abstract protected function rulesUpdate(): array;
    abstract protected function getService();
    abstract protected function getResource();

    public function index(): JsonResponse
    {
        $find = $this->getService()->findAll();
        $itens = $this->getResource()->arrayDtoToVoItens($find);
        return response()->json($itens, ResponseAlias::HTTP_OK);
    }

    public function show(int $id): JsonResponse
    {
        $find = $this->getService()->findById($id);
        if ($find) {
            return response()->json($this->getResource()->dtoToVo($find), ResponseAlias::HTTP_OK);
        }
        return response()->json('Registro não encontrado!', ResponseAlias::HTTP_NOT_FOUND);
    }

    public function insert(Request $request): JsonResponse
    {
        MfpValidator::validateRequest($request, $this->rulesInsert());
        $item = $this->getResource()->arrayToDto($request->json()->all());
        $insert = $this->getService()->insert($item);
        if ($insert) {
            return response()->json($this->getResource()->dtoToVo($insert), ResponseAlias::HTTP_CREATED);
        }
        return response()->json('Erro ao inserir item.', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        MfpValidator::validateRequest($request, $this->rulesUpdate());
        $requestItem = $request->json()->all();
        $requestItem['id'] = $id;
        $item = $this->getResource()->arrayToDto($requestItem);
        $updated = $this->getService()->update($id, $item);
        return response()->json($this->getResource()->dtoToVo($updated), ResponseAlias::HTTP_OK);
    }

    public function delete(int $id): ResponseFactory|Response
    {
        $this->getService()->deleteById($id);
        return response(null, ResponseAlias::HTTP_OK);
    }

    public function showByType(int $type): array
    {
        $itens = $this->getService()->findAllByType($type);
        return $this->getResource()->arrayDtoToVoItens($itens);
    }
}
