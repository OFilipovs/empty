<?php

namespace WSB\Services;

use WSB\Repositories\FinnHubStockRepository;
use WSB\Repositories\UserRepository;

class OrderService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id,
                            $stockSymbol,
                            $amount,
                            $order): ?string
    {
        $currentPrice = (new FinnHubStockRepository())->getStock($stockSymbol)->getCurrentPrice();
        $currentStockAmount = $this->repository->getStock($id, $stockSymbol);
        $purseValue = $currentPrice * $amount;
        if ($currentStockAmount >= $amount) {
            $this->repository->saveTransaction(
                $id,
                $stockSymbol,
                $amount,
                $purseValue,
                $currentPrice,
                $order);
            return "true";
        }

        return null;
    }
}