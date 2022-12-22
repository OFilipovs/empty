<?php

namespace WSB\DTO;

use WSB\Models\Collections\PurchasedStocksCollection;
use WSB\Models\Collections\StatisticsPurchasedStocksCollection;
use WSB\Models\Collections\StocksCollection;

class PortfolioIndexVariables
{
    public StocksCollection $stocksCollection;
    public PurchasedStocksCollection $ownedStocks;
    public float $moneyInWallet;
    public StatisticsPurchasedStocksCollection $statisticsCollection;

    public function __construct(
        StocksCollection $stocksCollection,
        PurchasedStocksCollection $ownedStocks,
        float $moneyInWallet,
        StatisticsPurchasedStocksCollection $statisticsCollection)
    {
        $this->stocksCollection = $stocksCollection;
        $this->ownedStocks = $ownedStocks;
        $this->moneyInWallet = $moneyInWallet;
        $this->statisticsCollection = $statisticsCollection;
    }
}