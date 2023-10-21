<?php

namespace App\http\middleware;

use SelfPhp\Auth; 
use SelfPhp\Page;
use SelfPhp\SP;

class AuthMiddleware 
{ 
    public static function AuthView()
    {
        if (strtolower($_ENV['AUTH']) == 'true') {
            if (Auth::auth() == false) { 
                if (!empty(strtolower(login_page()))) {  
                    route(login_page(), [
                        "status" => "error", 
                        "message" => "Login is required!"
                    ]);
                } else {
                    SP::debug_backtrace_show("LogoutDestinationNotSetException");
                }
            } 
        } 
    }
}



