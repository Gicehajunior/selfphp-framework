<?php

namespace App\http\middleware;

use SelfPhp\Auth; 
use SelfPhp\Page;

class AuthMiddleware 
{ 

    public function __construct()
    { 
    }

    public static function session_exists()
    {
        if (isset($_SESSION['id']) || isset($_SESSION['username']) || isset($_SESSION['email'])) {
            return true;
        }

        return false;
    }

    public function AuthView()
    { 
        if (strtolower($_ENV['AUTH']) == 'true') {
            if (AuthMiddleware::session_exists() == false) { 
                if (!empty(strtolower($_ENV['LOGOUT_DESTINATION']))) {
                    $page = new Page();
                    
                    $page->navigate_to(strtolower($_ENV['LOGOUT_DESTINATION']), ["error" => "Login is required!"]);
                } else {
                    echo "Logout destination not set in .env file. Please set to experience a smooth logout process!";
                    exit();
                }
            }
        } 
    }
}



