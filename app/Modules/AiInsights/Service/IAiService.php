<?php

namespace App\Modules\AiInsights\Service;

interface IAiService
{
    public function ask(array $messages);
}
