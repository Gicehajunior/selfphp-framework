<?php

use SelfPhp\SP;
use SelfPhp\Request;
use SelfPhp\Page;
use SelfPhp\Auth;
use SelfPhp\Serve;
use App\http\middleware\AuthMiddleware;
use App\models\DashboardModel;  
use App\services\MailerService; 

class DashboardController extends SP
{   
    public function __construct()
    { 
        AuthMiddleware::AuthView();
    }

    public function index()
    {
        return view("resources/views", "dashboard");
    }
    
}
