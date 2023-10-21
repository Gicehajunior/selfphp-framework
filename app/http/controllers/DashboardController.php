<?php
use SelfPhp\Request;

use SelfPhp\SP; 
use SelfPhp\Auth;
use SelfPhp\Serve;
use App\models\DashboardModel;  
use App\services\MailerService; 
use App\http\middleware\AuthMiddleware;

class DashboardController extends SP
{   
    public function __construct()
    { 
        AuthMiddleware::AuthView();
    }

    public function index()
    {
        return view("views.dashboard");
    }
    
}
