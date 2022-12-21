<?php
namespace WSB\Models\Collections;

use WSB\Models\Stock;

class StocksCollection
{
    private array $stocks = [];

    public function __construct()
    {
    }

    public function add(Stock $stock): void
    {
        $this->stocks [$stock->getStockSymbol()]= $stock;
    }

    public function getStocks(): array
    {
        return $this->stocks;
    }
}