<?php

namespace WSB\Models;

class PurchasedStock
{
    private string $stockSymbol;
    private int $stockAmount;
    private ?float $averagePrice;

    public function __construct(
        string $stockSymbol,
        int $stockAmount,
        float $averagePrice = null
    )
    {
        $this->stockSymbol = $stockSymbol;
        $this->stockAmount = $stockAmount;
        $this->averagePrice = $averagePrice ?? 0;
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