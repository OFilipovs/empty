<?php

namespace WSB\Services;

use WSB\DTO\PortfolioIndexVariables;
use WSB\Models\Collections\StocksCollection;
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
        foreach ($ownedStocks as $stock) {
            $stockCollection->add($this->stockRepository->getStock($stock["stock_symbol"]));
        }

        return new PortfolioIndexVariables
        (
            $stockCollection,
            $ownedStocks,
            $moneyInWallet
        );
    }
}