<?php
namespace WSB\Models;



use WSB\Repositories\StockRepository;

class Stock
{
    private string $stockSymbol;
    private ?float $previousClosePrice;
    private ?float $currentPrice;
    private string $companyName;

    public function __construct(
        string $stockSymbol,
        float $currentPrice,
        float $previousClosePrice,
        string $companyName
    )
    {
        $this->stockSymbol = $stockSymbol;
        $this->currentPrice = $currentPrice;
        $this->previousClosePrice = $previousClosePrice;
        $this->companyName = $companyName;
    }

    public function getStockSymbol(): string
    {
        return $this->stockSymbol;
    }

    public function getPreviousClosePrice(): float
    {
        return $this->previousClosePrice;
    }

    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }


}