<?php 

require "./config/view_config.php";

class AuthController{
    
    public $session_object;
    
    public function __construct()
    { 
        $this->session_object = null;
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

