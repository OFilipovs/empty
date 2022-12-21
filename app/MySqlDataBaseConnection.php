<?php

namespace WSB;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class MySqlDataBaseConnection
{
    private ?Connection $connection;

    public function __construct(Config $config)
    {
        $this->connection = DriverManager::getConnection($config->getConfig());
    }


    public function getConnection(): ?Connection
    {
        return $this->connection;
    }
}