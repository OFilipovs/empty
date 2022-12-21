<?php

namespace WSB\Services;

class validFormInputService
{
    public function separateValidFromInvalid(array $validationErrors, array $post): array
    {
        $ignore = ["password","confirmPassword"];
        return array_diff_key(array_diff_key($post, $validationErrors),array_flip($ignore));
    }
}