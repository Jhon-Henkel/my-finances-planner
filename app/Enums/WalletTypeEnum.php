<?php

namespace App\Enums;

enum WalletTypeEnum: int
{
    case Money = 5;
    case BankCount = 6;
    case MealTicket = 8;
    case TransportTicket = 9;
    case HealthInsurance = 10;
    case Other = 0;
}