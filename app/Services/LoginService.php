<?php

namespace WSB\Services;

class LoginService
{
    private ?string $email;
    private ?string $password;

    public function __construct(array $post)
    {
        $this->email = $post["email"] ?? null;
        $this->password = $post["password"] ?? null;
    }



    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function authorise($row): bool
    {
        return password_verify($this->password, $row["password"]);
    }
}