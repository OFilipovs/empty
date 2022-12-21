<?php
namespace WSB\ViewVariables;

use WSB\MySqlDataBaseConnection;


class AuthViewVariables
{
    private MySqlDataBaseConnection $connection;

    public function __construct(MySqlDataBaseConnection $connection)
    {

        $this->connection = $connection;
    }

    public function getName(): string
    {
        return "auth";
    }

    public function getValue(): array
    {
        if (! isset($_SESSION["auth_id"]))
        {
            return [];
        }
        $queryBuilder = $this->connection->getConnection()->createQueryBuilder();
        $user = $queryBuilder
            ->select("*")
            ->from("users")
            ->where("userid = ?")
            ->setParameter(0, $_SESSION['auth_id'])
            ->fetchAssociative();
        return [
            "id" => $user["userid"],
            "name" => $user["name"],
            "email" => $user["email"]
        ];
    }
}