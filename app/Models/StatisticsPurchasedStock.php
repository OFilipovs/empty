<?php

namespace WSB\Models;

class StatisticsPurchasedStock
{
    private string $symbol;
    private float $profitLoss;
    private float $totalValue;

    public function __construct(string $symbol, float $profitLoss, float $totalValue)
    {
        $this->symbol = $symbol;
        $this->profitLoss = $profitLoss;
        $this->totalValue = $totalValue;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function setProfitLoss(float $profitLoss): void
    {
        $this->profitLoss = $profitLoss;
    }

    public function setTotalValue(float $totalValue): void
    {
        $this->totalValue = $totalValue;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getProfitLoss(): float
    {
        return $this->profitLoss;
    }

    public function getTotalValue(): float
    {
        return $this->totalValue;
    }
}