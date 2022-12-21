<?php

namespace WSB\Repositories;



use WSB\Models\Collections\PurchasedStocksCollection;
use WSB\MySqlDataBaseConnection;
use WSB\Services\UserDetails;

interface UserRepository
{
    public function __construct(MySqlDataBaseConnection $connection);
    public function writeToTable(UserDetails $user);
    public function getStocks(int $id): PurchasedStocksCollection;
}