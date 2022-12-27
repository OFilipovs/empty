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
                            $order): string
    {
        $currentPrice = (new FinnHubStockRepository())->getStock($stockSymbol)->getCurrentPrice();
        $dollarBills = $this->repository->getUSD($id);

        $purseValue = $currentPrice * $amount;


        if (! preg_match("/^[1-9]\d*$/", $amount)) {
            return "Incorrect number format, only positive integers allowed";
        }

        if ( $dollarBills < $purseValue && $order === "BUY"){

            return "Not enough money in wallet";
        }

//        $currentStockAmount = $this->repository->getStock($id, $stockSymbol);


//        if (! ($currentStockAmount >= $amount) && $order === "SELL"){
//            return null;
//        }

        $this->repository->saveTransaction(
            $id,
            $stockSymbol,
            $amount,
            $purseValue,
            $currentPrice,
            $order);
        return "true";
    }
}