<?php
declare(strict_types=1);

namespace WSB\Services;

use Valitron\Validator;

class FormValidationService
{
    public function validateForm(array $userCredentials): ?array
    {
        $v = new Validator($userCredentials);
        $v->rule('required', ['name', 'email', "password", "confirmPassword"]);
        $v->rule('email', 'email');
        $v->rule("lengthMin","name", 4);
        $v->rule("lengthMin","password", 5);
        $v->rule("equals","password","confirmPassword");
        if($v->validate()) {
            return null;
        }

        return $v->errors();
    }
}