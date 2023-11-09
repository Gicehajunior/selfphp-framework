<?php

namespace App\http\middleware;

use SelfPhp\Auth; 
use SelfPhp\Page;
use SelfPhp\SP;

class AuthMiddleware 
{ 
    /**
     * Handles authentication for views.
     *
     * @return mixed Returns a route or throws an exception based on authentication status.
     * @throws \Exception If the login page is not found.
     */
    public static function AuthView()
    {
        if (strtolower(env("AUTH")) == 'true') {
            if (Auth::auth() == false) { 
                if (!empty(strtolower(login_page()))) {  
                    return route(login_page(), [
                        "status" => "error", 
                        "message" => "Login is required!"
                    ]);
                } else {
                    throw new \Exception("LogoutDestinationNotSetException: Login page not found!");
                }
            } 
        } 
    }
}



