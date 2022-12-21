<?php

namespace WSB\Controllers;

use WSB\Models\Collections\StocksCollection;
use WSB\Repositories\FinnHubStockRepository;
use WSB\Template;


class HomeController
{

    public function __construct()
    {
    }

    public function index(): Template
    {
        $repository = new FinnHubStockRepository();
        $stockCollection = new StocksCollection();
        $stockSymbols = ["AAPL", "GME", "CLF", "TSM", "AEHR", "F", "GM", "TSLA", "MSFT", "TWTR"];
        foreach ($stockSymbols as $symbol) {
            $stockCollection->add($repository->getStock($symbol));
        }
        return new Template
        (
            "home.twig",
            [
                "stocks" => $stockCollection->getStocks()
            ]
        );
    }
}

