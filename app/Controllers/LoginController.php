<?php

namespace WSB\Controllers;

use WSB\Repositories\MySqlUserRepository;
use WSB\Services\LoginService;
use WSB\Template;

class LoginController
{
    private MySqlUserRepository $dataBaseRepository;
    public function __construct(MySqlUserRepository $repository)
    {
        $this->dataBaseRepository = $repository;
    }

    public function loginForm(): Template
    {
        return new Template
        (
            "login.twig",
            [

            ]
        );
    }

    public function login()
    {
        $credentials = new LoginService
        (
            $_POST
        );


        $row = $this->dataBaseRepository->retrieveId($credentials->getEmail());

        if ($row > 0 && $credentials->authorise($row)){
            $_SESSION['auth_id'] = $row["id"];
            return new Template
            (
                "welcome.twig",
                [
                    "name" => $row["name"]
                ]
            );
        } else {
            $_SESSION["errors"]["login"] = "Wrong password or email";
            header("Location: /loginForm");
        }
    }

    public function logout()
    {
        unset($_SESSION["auth_id"]);
        header("Location: /");
    }


}