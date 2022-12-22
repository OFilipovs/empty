<?php

namespace WSB\Models\Collections;

use WSB\Models\StatisticsPurchasedStock;

class StatisticsPurchasedStocksCollection
{
    private array $stocks = [];

    public function add(StatisticsPurchasedStock $stock): void
    {
        $this->stocks [$stock->getSymbol()]= $stock;
    }

    public function getPurchasedStatistics(): array
    {
        return $this->stocks;
    }
}