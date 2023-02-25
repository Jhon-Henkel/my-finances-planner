<?php

namespace App\BO;

use Illuminate\Http\Request;

abstract class BasicBO
{
    public function apiIndex()
    {
        return $this->dao->indexTeste();
    }

    public function apiGet(int $id)
    {
        return $this->dao->getModel($id);
    }

    public function apiInsert(Request $request)
    {
        return $this->dao->postTeste($request);
    }

    public function apiUpdate(int $id, Request $request)
    {
        return $this->dao->putTeste($id, $request);
    }

    public function apiDelete(int $id)
    {
        return $this->dao->deleteTeste($id);
    }
}
