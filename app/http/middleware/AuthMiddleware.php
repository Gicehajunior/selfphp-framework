<?php

namespace App\http\middleware;

use SelfPhp\Auth; 
use SelfPhp\Page;

class AuthMiddleware 
{ 

    public function __construct()
    { 
    }

    public static function AuthView()
    {
        if (strtolower($_ENV['AUTH']) == 'true') {
            if (Auth::auth() == false) { 
                if (!empty(strtolower($_ENV['LOGOUT_DESTINATION']))) {
                    $page = new Page(); 

                    $page->View("resources/auth", $_ENV['LOGOUT_DESTINATION'], ["message" => "Login is required!"]);
                } else {
                    echo "Logout destination not set in .env file. Please set to experience a smooth logout process!";
                    exit();
                }
            }
        } 
    }
}



