<?php 

require "./config/view_config.php";

class AuthController{
    
    public function __construct()
    { 
        
    }

    public function login() {
        $page = new Page();
        
        $page->View("resources/auth", "login");
    }

    public function signup()
    {
        $page = new Page();

        $page->View("resources/auth", "register");
    }
} 

