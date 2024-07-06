<?php

namespace App\Enums;

enum InvoiceInstallmentsEnum: int
{
    case MaxInstallments = 6;
    case FixedInstallments = 0;
}
