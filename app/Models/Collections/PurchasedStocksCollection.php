<?php

namespace WSB\Models\Collections;

use WSB\Models\PurchasedStock;

class PurchasedStocksCollection
{
    private array $stocks = [];

    public function add(PurchasedStock $stock): void
    {
        $this->stocks [$stock->getStockSymbol()]= $stock;
    }

    public function getPurchasedStocks(): array
    {
        return $this->stocks;
    }
}