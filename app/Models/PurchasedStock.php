<?php

namespace WSB\Models;

class PurchasedStock
{
    private string $stockSymbol;
    private int $stockAmount;
    private float $averagePrice;

    public function __construct(
        string $stockSymbol,
        int $stockAmount,
        float $averagePrice
    )
    {
        $this->stockSymbol = $stockSymbol;
        $this->stockAmount = $stockAmount;
        $this->averagePrice = $averagePrice;
    }

    public function getStockSymbol(): string
    {
        return $this->stockSymbol;
    }

    public function getStockAmount(): int
    {
        return $this->stockAmount;
    }

    public function getAveragePrice(): float
    {
        return $this->averagePrice;
    }


}