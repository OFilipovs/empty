<?php

namespace WSB\Services;


use WSB\Repositories\StockRepository;


class OrderFormService
{
    private StockRepository $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function execute($stockSymbol)
    {
        return $this->stockRepository->getStock($stockSymbol)->getCurrentPrice();
    }
}