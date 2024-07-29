<?php

namespace App\Services\Database;

require_once __DIR__ . '/../../../vendor/kinghost/api-php/Mysql.php';

use App\Exceptions\Database\CreateNewDatabaseException;
use App\Tools\AppTools;
use Illuminate\Support\Facades\Schema;
use Mysql;

class DatabaseService
{
    public function createTenancyDatabase(string $dbPassword, string $dbDescription): string
    {
        if (AppTools::isLocalhost()) {
            return $this->createLocalhostDatabase($dbDescription);
        }
        $domainId = config('app.db_server_domain_id');
        $database = $this->getDatabaseConnection();
        $result = $database->addBanco(['obs' => $dbDescription, 'senha' => $dbPassword, 'idDominio' => $domainId]);
        CreateNewDatabaseException::throwIfDatabaseNotCreated($result['status']);
        return $result['BancoNome'];
    }

    protected function createLocalhostDatabase(string $dbDescription): string
    {
        $databaseName = md5($dbDescription);
        Schema::createDatabase($databaseName);
        return $databaseName;
    }

    /** @phpstan-ignore-next-line */
    protected function getDatabaseConnection(): Mysql
    {
        return new Mysql(
            config('app.db_server_login'),
            config('app.db_server_password')
        );
    }
}
