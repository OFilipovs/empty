<?php

namespace WSB\Controllers;

use WSB\Services\PortfolioIndexService;
use WSB\Services\OrderService;
use WSB\Services\OrderFormService;
use WSB\Services\TransactionViewService;
use WSB\Template;

class PortfolioController
{
    private OrderService $orderService;
    private PortfolioIndexService $indexService;
    private OrderFormService $orderFormService;
    private TransactionViewService $transactionViewService;

    public function __construct(
        OrderService          $orderService,
        PortfolioIndexService $indexService,
        OrderFormService $orderFormService,
        TransactionViewService $transactionViewService
    )
    {
        $this->orderService = $orderService;
        $this->indexService = $indexService;
        $this->orderFormService = $orderFormService;
        $this->transactionViewService = $transactionViewService;
    }

    public function index(): Template
    {
        // calculate Profit / Loss
        // new Model for calculations P/L Total ;Cost utt

        $id = $_SESSION["auth_id"];
        $portfolioIndexVariables = $this->indexService->execute($id);
        return new Template
        (
            "portfolio.twig",
            [
                "stocks" => $portfolioIndexVariables->ownedStocks->getPurchasedStocks(),
                "marketData" => $portfolioIndexVariables->stocksCollection,
                "money" => $portfolioIndexVariables->moneyInWallet,
                "statistics" => $portfolioIndexVariables->statisticsCollection->getPurchasedStatistics()
            ]
        );
    }

    public function order()
    {
        $userID = $_SESSION["auth_id"];
        $stockSymbol = $_GET["stockSymbol"];
        $amount = $_POST["amount"];
        $order = $_GET["orderType"];
        $response = $this->orderService->execute(
            $userID,
            $stockSymbol,
            $amount,
            $order);

        if ($response === "true")
        {
            header("Location: /portfolio");
        }
        else {
            $_SESSION["errors"]["amountError"] = "You don't have enough shares of $stockSymbol";
            header("Location: /sellForm?stockSymbol=$stockSymbol");
        }
    }

    public function orderForm(): Template
    {
        // dependancy inject service
        $stockSymbol = $_GET["stockSymbol"];
        $currentPrice = $this->orderFormService->execute($stockSymbol);
        return new Template
        (
            "orderForm.twig",
            [
                "price" => $currentPrice,
                "symbol" => $stockSymbol
            ]
        );
    }

    public function transactionView(): Template
    {
        // dependancy inject service
        $userId = $_SESSION["auth_id"];
        $stockSymbol = $_GET["stockSymbol"];
        $transactions = $this->transactionViewService->execute($stockSymbol, $userId);
        return new Template
        (
            "transactions.twig",
            [
                "stock" => $stockSymbol,
                "stockTransactions" => $transactions
            ]
        );
    }
}