<?php

namespace App\http\middleware;

use SelfPhp\Auth;
use SelfPhp\Page;
use SelfPhp\SP;

/**
 * Class AuthMiddleware
 * Middleware for handling authentication on views.
 */
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
        // Check if authentication is enabled in the environment.
        if (!env("AUTH")) {
            throw new \Exception("Authentication ability is turned off!");
        }

        // If not authenticated, redirect to the login page or throw an exception.
        if (Auth::auth() == false) { 
            if (empty(strtolower(login_page()))) { 
                // Throw an exception if the login page is not found.
                throw new \Exception("LogoutDestinationNotSetException: Login page not found!");
            }
            
            // Redirect to the login page with an error message.
            return route(login_page(), [
                "status" => "error",
                "message" => "Login is required!"
            ]);
        } 
    }
}
