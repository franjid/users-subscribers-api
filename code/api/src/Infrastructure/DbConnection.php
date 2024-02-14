<?php

namespace Project\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DbConnection
{
    public function getConnection(): Connection
    {
        $connectionParams = array(
            'host' => getenv('MYSQL_HOST'),
            'user' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_PASSWORD'),
            'dbname' => 'app',
            'driver' => 'pdo_mysql',
        );

        return DriverManager::getConnection($connectionParams);
    }
}
