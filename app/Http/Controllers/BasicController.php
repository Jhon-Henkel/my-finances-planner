<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

abstract class BasicController extends BaseController implements BasicControllerContract
{
    protected abstract function rulesInsert():array;
    protected abstract function rulesUpdate():array;
    protected abstract function getService();
    protected abstract function getResource();

    public function index(): JsonResponse
    {
        try {
            $find = $this->getService()->findAll();
            return count($find) == 0
                ? response()->json(array(), ResponseAlias::HTTP_OK)
                : response()->json($find, ResponseAlias::HTTP_OK);
        } catch (QueryException $exception) {
            return $this->returnErrorDatabaseConnect();
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $find = $this->getService()->findById($id);
            return $find
                ? response()->json($find, ResponseAlias::HTTP_OK)
                : response()->json('Registro não encontrado!',ResponseAlias::HTTP_NOT_FOUND);
        } catch (QueryException $exception) {
            return $this->returnErrorDatabaseConnect();
        }
    }

    public function insert(Request $request): JsonResponse
    {
        try {
            $invalid = $this->getService()->isInvalidRequest($request, $this->rulesInsert());
            if ($invalid instanceof MessageBag) {
                return response()->json($invalid, ResponseAlias::HTTP_BAD_REQUEST);
            }
            $item = $this->getResource()->arrayToDto($request->json()->all());
            $insert = $this->getService()->insert($item);
            return $insert
                ? response()->json($insert->getAttributes(), ResponseAlias::HTTP_CREATED)
                : response()->json('Erro ao inserir item.', ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        } catch (QueryException $exception) {
            return $this->returnErrorDatabaseConnect();
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $invalid = $this->getService()->isInvalidRequest($request, $this->rulesUpdate());
            if ($invalid instanceof MessageBag) {
                return response()->json($invalid, ResponseAlias::HTTP_BAD_REQUEST);
            }
            $item = $this->getResource()->arrayToDto($request->json()->all());
            $updated = $this->getService()->update($id, $item);
            return response()->json($updated, ResponseAlias::HTTP_OK);
        } catch (QueryException $exception) {
            return $this->returnErrorDatabaseConnect();
        }
    }

    public function delete(int $id): Response|JsonResponse|ResponseFactory
    {
        try {
            $this->getService()->deleteById($id);
            return response(null, ResponseAlias::HTTP_OK);
        } catch (QueryException $exception) {
            return $this->returnErrorDatabaseConnect();
        }
    }

    protected function returnErrorDatabaseConnect(): JsonResponse
    {
        return response()->json(
            'Erro ao se conectar com o banco de dados',
            ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
