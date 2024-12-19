<?php

namespace App\Modules\CreditCardInvoice\Exceptions;

use App\Exceptions\ResponseExceptions\BadRequestException;

class CreditCardIdNotFountInRoute extends BadRequestException
{
    public function __construct()
    {
        parent::__construct('O ID do cartão de crédito não foi encontrado na rota!');
    }

    public static function throwIfNot(bool $condition): void
    {
        if (!$condition) {
            throw new self();
        }
    }
}
