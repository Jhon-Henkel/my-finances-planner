<?php

namespace App\BO;

use App\DAO\TesteDAO;
use App\DAO\TesteDaoContract;

class TesteBO extends BasicBO
{
    protected TesteDAO $dao;

    public function __construct(TesteDaoContract $dao)
    {
        $this->dao = $dao;
    }
}
