<?php

namespace WSB\Services;

use WSB\Repositories\StockRepository;
use WSB\Repositories\UserRepository;

class CompileUserPortfolioService

{
    private UserRepository $userData;
    private StockRepository $stockData;
    private int $id;

    public function __construct(UserRepository $userData, StockRepository $stockData, int $id)
    {
        $this->userData = $userData;
        $this->stockData = $stockData;
        $this->id = $id;
    }

    public function execute(): Portfolio
    {
        $ownedStocks = $this->userData->getStocks($this->id);

    }
}