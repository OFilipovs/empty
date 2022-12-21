<?php

namespace WSB;

class Config
{
    private array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            "host" => $env["DB_HOST"],
            "user" => $env["DB_USER"],
            "password" => $env["DB_PASS"],
            "dbname" => $env["DB_DATABASE"],
            "driver" => "pdo_mysql"
        ];
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}