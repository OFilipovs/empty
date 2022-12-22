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
//        show users only nickname in table
        // add button "send"
        // deduct from sender, add to receiver
        // nice to have, visible in transaction history
        $hello = "HELLO";

        return new Template
        (
            "transfer.twig",
            [
                "hello" => $hello
            ]
        );
    }
}