<?php

namespace WSB\Models\Collections;

use WSB\Models\RegisteredUser;

class UsersCollection
{
    private array $users = [];

    public function add(RegisteredUser $user): void
    {
        $this->users [$user->getId()]= $user;
    }

    public function getRegisteredUsers(): array
    {
        return $this->users;
    }
}