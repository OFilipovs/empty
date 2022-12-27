<?php

namespace WSB\Controllers;

use League\Csv\Exception;
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

    public function search(): Template
    {

        $stockSymbol = $_GET["stockSymbol"];

        try {
            $currentPrice = (new FinnHubStockRepository())->getStock($stockSymbol)->getCurrentPrice();
        } catch (Exception $e){
            header("Location: /");
        }

        return new Template
        (
            "searchForm.twig",
            [
                "price" => $currentPrice,
                "symbol" => $stockSymbol
            ]
        );
    }
}

