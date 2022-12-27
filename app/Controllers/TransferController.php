<?php

namespace WSB\Controllers;

use WSB\Repositories\UserRepository;
use WSB\Template;

class TransferController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): Template
    {
        $id = $_SESSION["auth_id"];
        $users = $this->userRepository->getUsers($id);
        $ownedStocks = $this->userRepository->getStocks($id);

        return new Template
        (
            "transfer.twig",
            [
                "users" => $users->getRegisteredUsers(),
                "purchasedStocks" => $ownedStocks->getPurchasedStocks()
            ]
        );
    }

    public function send()
    {
        // nice to have, visible in transaction history

        $receiverEmail = $_POST["email"];
        $amount =$_POST["amount"];
        $stock = $_POST["purchasedStock"];
        $senderId = $_SESSION["auth_id"];
        $ownedStock = $this->userRepository->getStock($senderId,$stock);
        if ($ownedStock->getStockAmount() >= $amount ){
            $this->userRepository->transfer($receiverEmail,$amount,$stock, $senderId);
            $_SESSION["validInputs"] = "You have sent $amount shares of $stock stock to $receiverEmail";
            header("Location: /transfers");
        } else {
            $_SESSION["errors"] = "You don't have enough shares";
            header("Location: /transfers");
        }
    }
}