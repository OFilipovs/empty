<?php

namespace WSB\Services;

class UserDetails
{
    private string $userName;
    private string $email;
    private string $userPassword;
    private string $confirmPassword;


    public function __construct(array $post)
    {
        $this->userName = $post["name"];
        $this->email = $post["email"];
        $this->userPassword = $post["password"];
        $this->confirmPassword = $post["confirmPassword"];
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserPassword(): string
    {
        return $this->userPassword;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }
}