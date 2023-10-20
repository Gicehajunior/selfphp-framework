<?php

namespace SelfPhp;

use SelfPhp\Page;

class Auth extends Page
{

    public static function hash_pass($password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $hashed_password;
    }

    public static function verify_pass($password, $hashed_password)
    {
        if (password_verify($password, $hashed_password)) {
            return true;
        }

        return false;
    }
    
    public static function push_session($session_object)
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

    public static function start_session($session_object = [])
    {
        if (is_array($session_object)) {
            if (count($session_object) > 0) {
                foreach ($session_object as $key => $value) {
                    $_SESSION["auth"][$key] = $value;
                }

                return true;
            }
        } else {
            return false;
        }
    }

    public static function auth() {
        if (isset($_SESSION['auth'])) {
            if (count($_SESSION['auth']) > 0) { 
                return true;
            }
        }

        return false;
    }

    public static function User($key)
    {
        $session = (isset($_SESSION['auth'][$key])) ? $_SESSION['auth'][$key] : null;

        return $session;
    } 

    public static function get_session($key)
    {
        $session_array = [];
        
        if (is_array($key)){
            foreach ($key as $value) {
                $session_array[$value] = (isset($_SESSION[$value])) ? $_SESSION[$value] : null;
            }
        }
        else {
            $session_array[$key] = (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
        }

        return $session_array[$key];
    }
    
    public static function boot_out()
    {
        if (session_destroy() || session_unset()) {
            return true;
        }

        return false;
    }
}
