<?php

namespace WSB\Services;

use WSB\Repositories\UserRepository;

class TransactionViewService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute($stockSymbol, $userId)
    {
        return $this->userRepository->getTransactions($stockSymbol, $userId);
    }
}