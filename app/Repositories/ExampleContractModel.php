<?php

namespace App\Repositories;

use Illuminate\Http\Request;
/**
 * @deprecated Classe para exemplo, excluirei em breve
 */
interface ExampleContractModel
{
    public function indexTeste();
    public function getModel(int $id);
    public function postTeste(Request $request);
    public function putTeste(int $id, Request $request);
    public function deleteTeste(int $id);
}
