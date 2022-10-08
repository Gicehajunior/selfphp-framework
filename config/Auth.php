<?php

namespace SelfPhp;

use SelfPhp\Page;

class Auth extends Page
{

    public function __construct()
    {
    }

    public static function hash_pass($password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $hashed_password;
    }

    public static function start_session($session_object = [])
    {
        if (is_array($session_object)) {
            if (count($session_object) > 0) {
                foreach ($session_object as $key => $value) {
                    $_SESSION[$key] = $value;
                }

                return true;
            }
        } else {
            return false;
        }
    }

    public static function auth() {
        if (count($_SESSION) > 0) {
            return true;
        }

        return false;
    }

    public static function User($key)
    {
        $session = (isset($_SESSION[$key])) ? $_SESSION[$key] : null;

        return $session;
    } 
    
    public static function boot_out()
    {
        if (session_destroy() || session_unset()) {
            return true;
        }

        return false;
    }
}
