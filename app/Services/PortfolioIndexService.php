<?php

namespace WSB\Services;

use WSB\DTO\PortfolioIndexVariables;
use WSB\Models\Collections\StatisticsPurchasedStocksCollection;
use WSB\Models\Collections\StocksCollection;
use WSB\Models\StatisticsPurchasedStock;
use WSB\Repositories\StockRepository;
use WSB\Repositories\UserRepository;

class PortfolioIndexService
{
    private UserRepository $userRepository;
    private StockRepository $stockRepository;

    public function __construct(UserRepository $userRepository, StockRepository $stockRepository)
    {
        $this->userRepository = $userRepository;
        $this->stockRepository = $stockRepository;
    }

    public function execute($id): PortfolioIndexVariables
    {
        $ownedStocks = $this->userRepository->getStocks($id);
        $stockCollection = new StocksCollection();
        $moneyInWallet = $this->userRepository->getUSD($id);

        foreach ($ownedStocks->getPurchasedStocks() as $stock) {
            $stockCollection->add($this->stockRepository->getStock($stock->getStockSymbol()));
        }

        $marketDataForStocks = $stockCollection->getStocks();
        $statisticsCollection = new StatisticsPurchasedStocksCollection();
        foreach ($ownedStocks->getPurchasedStocks() as $stock) {
            $symbolOwned = $stock->getStockSymbol();
            $amountOwned = $stock->getStockAmount();
            $profitLoss = ($marketDataForStocks[$symbolOwned]->getCurrentPrice() - $stock->getAveragePrice()) * $amountOwned;
            $totalValue = $marketDataForStocks[$symbolOwned]->getCurrentPrice() * $amountOwned;
            $statisticsCollection->add(
                new StatisticsPurchasedStock(
                    $symbolOwned,
                    $profitLoss,
                    $totalValue
                )
            );
        }

        return new PortfolioIndexVariables
        (
            $stockCollection,
            $ownedStocks,
            $moneyInWallet,
            $statisticsCollection
        );
    }
}