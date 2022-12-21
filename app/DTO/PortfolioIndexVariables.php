<?php

namespace WSB\DTO;

use WSB\Models\Collections\StocksCollection;

class PortfolioIndexVariables
{
    public StocksCollection $stocksCollection;
    public array $ownedStocks;
    public float $moneyInWallet;

    public function __construct(
        StocksCollection $stocksCollection,
        array $ownedStocks,
        float $moneyInWallet)
    {
        $this->stocksCollection = $stocksCollection;
        $this->ownedStocks = $ownedStocks;
        $this->moneyInWallet = $moneyInWallet;
    }
}