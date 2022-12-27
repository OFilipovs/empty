<?php

namespace WSB\Repositories;



use WSB\Models\Collections\PurchasedStocksCollection;
use WSB\Models\PurchasedStock;
use WSB\MySqlDataBaseConnection;
use WSB\Services\UserDetails;

interface UserRepository
{
    public function writeToTable(UserDetails $user);
    public function getStocks(int $id): PurchasedStocksCollection;
    public function getUsers($id);
    public function transfer ($email, $amount, $symbol, $senderId);
    public function getStock(int $id, string $stockSymbol): PurchasedStock;
    public function getUSD(string $id): float;
}