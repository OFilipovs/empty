<?php

namespace WSB\Controllers;

use WSB\Repositories\MySqlUserRepository;
use WSB\Services\FormValidationService;
use WSB\Services\UserDetails;
use WSB\Services\validFormInputService;
use WSB\Template;


class RegistrationController
{
    public function index(): Template
    {
        return new Template
        (
            "registrationForm.twig",
            [

            ]
        );
    }

    public function registrationConfirm(): Template
    {
        return new Template
        (
            "registerConfirmation.twig",
            [

            ]
        );
    }


    public function register()
    {
        $userCredentials = $_POST;
        $validationErrors = (new FormValidationService())->validateForm($userCredentials);
        if ($validationErrors === null)
        {
            (new MySqlUserRepository())->writeToTable(new UserDetails($_POST));
            header("Location: /registerConfirmation");
        } else {
            $_SESSION["errors"] = $validationErrors;
            $_SESSION["validInputs"] = (new validFormInputService())->separateValidFromInvalid($validationErrors, $_POST);
            header("Location: /signup");
        }
    }

}