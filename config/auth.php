<?php

class Auth {
    public static function hash_pass($password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $hashed_password;
    }
}


