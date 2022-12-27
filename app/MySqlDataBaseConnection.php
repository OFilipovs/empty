<?php

namespace WSB;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class MySqlDataBaseConnection
{
    private ?Connection $connection;

    public function __construct()
    {
        $this->connection = DriverManager::getConnection(
            [
                "host" => "localhost",
                "user" => "root",
                "password" => "root",
                "dbname" => "sign_up",
                "driver" => "pdo_mysql"
            ]
        );
    }

    public function getConnection(): ?Connection
    {
        return $this->connection;
    }
}