<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface TesteRepositoryInterface
{
    public function indexTeste();
    public function getTeste(int $id);
    public function postTeste(Request $request);
    public function putTeste(int $id, Request $request);
    public function deleteTeste(int $id);
}
