<?php
namespace WSB\Repositories;

use WSB\Models\Stock;

interface StockRepository
{
    public function getStock(string $symbol): Stock;
}