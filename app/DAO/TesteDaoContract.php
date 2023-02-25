<?php

namespace App\DAO;

use Illuminate\Http\Request;

interface TesteDaoContract
{
    public function indexTeste();
    public function getModel(int $id);
    public function postTeste(Request $request);
    public function putTeste(int $id, Request $request);
    public function deleteTeste(int $id);
}
