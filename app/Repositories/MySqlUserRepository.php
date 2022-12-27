<?php

namespace WSB\Repositories;

use WSB\Models\Collections\PurchasedStocksCollection;
use WSB\Models\Collections\UsersCollection;
use WSB\Models\PurchasedStock;
use WSB\Models\RegisteredUser;
use WSB\MySqlDataBaseConnection;
use WSB\Services\UserDetails;

class MySqlUserRepository implements UserRepository
{
    private MySqlDataBaseConnection $connection;

    public function __construct(MySqlDataBaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function writeToTable(UserDetails $user): void
    {
        $this->connection->getConnection()->insert('users',
            [
                'name' => $user->getUserName(),
                'email' => $user->getEmail(),
                'password' => password_hash($user->getUserPassword(), PASSWORD_DEFAULT),
                "wallet" => 10000
            ]);
    }

    public function retrieveId($email): ?array
    {
        $queryBuilder = $this->connection->getConnection()->createQueryBuilder();
        $user = $queryBuilder
            ->select("*")
            ->from("users")
            ->where("email = ?")
            ->setParameter(0, $email)
            ->fetchAssociative();
        return [
            "id" => $user["userid"],
            "name" => $user["name"],
            "email" => $user["email"],
            "password" => $user["password"]
        ];
    }

    public function retrieveById($id){
        $queryBuilder = $this->connection->getConnection()->createQueryBuilder();
        $user = $queryBuilder
            ->select("*")
            ->from("users")
            ->where("userid = ?")
            ->setParameter(0, $id)
            ->fetchAssociative();
        return [
            "id" => $user["userid"],
            "name" => $user["name"],
            "email" => $user["email"],
            "password" => $user["password"]
        ];
    }

    public function getStocks(int $id): PurchasedStocksCollection
    {
        $queryBuilder = $this->connection->getConnection()->createQueryBuilder();
        $userStocks = $queryBuilder
            ->select("stock_symbol, stock_amount")
            ->from("stocks")
            ->where("user_id = ?")
            ->andWhere("stock_amount != 0")
            ->setParameter(0, $id)
            ->fetchAllAssociative();

        $stocksTransactions = $queryBuilder
            ->select("transactions.stock_symbol, SUM(stock_price * transactions.stock_amount)/SUM(transactions.stock_amount) AS average_price")
            ->from("transactions")
            ->where("transactions.user_id = ?")
            ->andWhere("action_type = 'BUY' ")
            ->setParameter(0, $id)
            ->groupBy("stock_symbol")
            ->fetchAllAssociativeIndexed();

        $purchasedStocksCollection = new PurchasedStocksCollection();
        foreach ($userStocks as $stock){
            $purchasedStocksCollection->add
            (
                new PurchasedStock(
                    $stock["stock_symbol"],
                    $stock["stock_amount"],
                    $stocksTransactions[$stock["stock_symbol"]]["average_price"]
                )
            );
        }
        return $purchasedStocksCollection;
    }

    public function getStock(int $id, string $stockSymbol): PurchasedStock
    {
        $queryBuilder = $this->connection->getConnection()->createQueryBuilder();
        $userStock = $queryBuilder
            ->select("stock_symbol, stock_amount")
            ->from("stocks")
            ->where("user_id = ?")
            ->andWhere("stock_symbol = ?")
            ->setParameter(0, $id)
            ->setParameter(1, $stockSymbol)
            ->fetchAllAssociative();

        return new PurchasedStock(
            $userStock[0]["stock_symbol"],
            $userStock[0]["stock_amount"]
        );
    }

    public function saveTransaction(
        int $id,
        string $symbol,
        int $shares,
        int $purseValue,
        float $price,
        string $order
    ): void
    {
        $operator = $order === "BUY" ? "-" : "+";
        $amount = ($operator . $shares) * -1;
        $connection = $this->connection->getConnection();


        $queryBuilder = $connection->createQueryBuilder();
        $userStocks = $queryBuilder
            ->select("stock_symbol")
            ->from("stocks")
            ->where("user_id = ?")
            ->andWhere("stock_symbol = ?")
            ->setParameter(0, $id)
            ->setParameter(1, $symbol)
            ->fetchAllAssociative();

        if (! $userStocks){
            $queryBuilder
                ->insert("stocks")
                ->values(
                    [
                        "user_id" => ":id",
                        "stock_symbol" => ":symbol",
                        "stock_amount" => ":amount",
                    ]
                )
                ->setParameters(
                    [
                        'id' => $id,
                        'symbol' => $symbol,
                        'amount' => $amount,
                    ]
                );
            $queryBuilder->executeQuery();
        } else {
            $queryBuilder
                ->update("stocks")
                ->set("stock_amount", "stock_amount + :amount")
                ->where("user_id = :id")
                ->andWhere("stock_symbol = :symbol")
                ->setParameters(
                    [
                        'id' => $id,
                        'symbol' => $symbol,
                        'amount' => $amount,
                    ]
                );
            $queryBuilder->executeQuery();
        }

//        $query = "INSERT INTO stocks (
//                user_id,
//                stock_symbol,
//                stock_amount,
//                order_price
//                ) VALUES (
//                          :id,
//                          :symbol,
//                          :amount,
//                          :price) ON DUPLICATE KEY UPDATE user_id = :id,
//                                                          stock_amount = stock_amount + :amount,
//                                                          order_price = :price";
//
//        $statement = $connection->prepare($query);
//        $statement->bindValue(':id', $id);
//        $statement->bindValue(':symbol', $symbol);
//        $statement->bindValue(':amount', $amount);
//        $statement->bindValue(':price', $price);
//        $statement->executeStatement();




        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder
            ->insert("transactions")
            ->values(
                [
                    "user_id" => ":id",
                    "stock_symbol" => ":symbol",
                    "stock_amount" => ":amount",
                    "stock_price" => ":price",
                    "action_type" => ":order",
                    "action_date" => ":date",
                ]
            )
            ->setParameters(
                [
                    'id' => $id,
                    'symbol' => $symbol,
                    'amount' => $amount,
                    'price' => $price,
                    'order' => $order,
                    'date' => time(),
                ]
            );
        $queryBuilder->executeQuery();

        $queryBuilder
            ->update("users")
            ->set('wallet', 'wallet' . $operator . ':purseValue')
            ->where("userid = :id")
            ->setParameters(
                [
                    'id' => $id,
                    'purseValue' => $purseValue
                ]
            );
        $queryBuilder->executeQuery();
    }

    public function getUSD(string $id): float
    {
        $queryBuilder = $this->connection->getConnection()->createQueryBuilder();
        return $queryBuilder
            ->select("wallet")
            ->from("users")
            ->where("userid = ?")
            ->setParameter(0, $id)
            ->fetchOne();
    }

    public function getTransactions(string $symbol, int $id): array
    {
        $queryBuilder = $this->connection->getConnection()->createQueryBuilder();
        return $queryBuilder
            ->select("stock_symbol, stock_amount, action_type, action_date, stock_price")
            ->from("transactions")
            ->where("user_id = ?")
            ->andWhere("stock_symbol = ?")
            ->addOrderBy("action_date", "DESC")
            ->setParameter(0, $id)
            ->setParameter(1, $symbol)
            ->fetchAllAssociative();
    }

    public function getUsers($id): UsersCollection
    {
        $queryBuilder = $this->connection->getConnection()->createQueryBuilder();
        $users = $queryBuilder
            ->select("*")
            ->from("users")
            ->where("userid != :id")
            ->setParameter("id",$id )
            ->fetchAllAssociative();

        $collection = new UsersCollection;

        foreach ($users as $user){
            $collection->add(
                new RegisteredUser(
                    $user["userid"],
                    $user["name"],
                    $user["email"]
                )
            );
        }
        return $collection;
    }

    public function transfer ($email, $amount, $symbol, $senderId)
    {
        $connection = $this->connection->getConnection();
        $receiverId = $this->retrieveId($email)["id"];

        $queryBuilder = $connection->createQueryBuilder();
        $userStocks = $queryBuilder
            ->select("stock_symbol")
            ->from("stocks")
            ->where("user_id = ?")
            ->andWhere("stock_symbol = ?")
            ->setParameter(0, $receiverId)
            ->setParameter(1, $symbol)
            ->fetchAllAssociative();

        if (! $userStocks){
            $queryBuilder
                ->insert("stocks")
                ->values(
                    [
                        "user_id" => ":id",
                        "stock_symbol" => ":symbol",
                        "stock_amount" => ":amount",
                    ]
                )
                ->setParameters(
                    [
                        'id' => $receiverId,
                        'symbol' => $symbol,
                        'amount' => $amount,
                    ]
                );
            $queryBuilder->executeQuery();

            $queryBuilder
                ->update("stocks")
                ->set("stock_amount", "stock_amount - :amount")
                ->where("user_id = :id")
                ->andWhere("stock_symbol = :symbol")
                ->setParameters(
                    [
                        'id' => $senderId,
                        'symbol' => $symbol,
                        'amount' => $amount,
                    ]
                );
            $queryBuilder->executeQuery();
        } else {
            $queryBuilder
                ->update("stocks")
                ->set("stock_amount", "stock_amount + :amount")
                ->where("user_id = :id")
                ->andWhere("stock_symbol = :symbol")
                ->setParameters(
                    [
                        'id' => $receiverId,
                        'symbol' => $symbol,
                        'amount' => $amount,
                    ]
                );
            $queryBuilder->executeQuery();

            $queryBuilder2 = $connection->createQueryBuilder();
            $queryBuilder2
                ->update("stocks")
                ->set("stock_amount", "stock_amount - :amount")
                ->where("user_id = :id")
                ->andWhere("stock_symbol = :symbol")
                ->setParameters(
                    [
                        'id' => $senderId,
                        'symbol' => $symbol,
                        'amount' => $amount,
                    ]
                );
            $queryBuilder2->executeQuery();
        }

//        $statement = $connection->prepare($query);
//        $statement->bindValue(':id', $receiver["id"]);
//        $statement->bindValue(':symbol', $symbol);
//        $statement->bindValue(':amount', $amount);
//        $statement->bindValue(':price', $price);
//        $statement->executeStatement();
    }
}