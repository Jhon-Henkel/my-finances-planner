<?php

namespace App\Enums\Database;

enum DatabaseConnectionEnum: string
{
    case Tenant = 'tenant';
    case Master = 'mysql';
    case Test = 'mysql_testing';
}
