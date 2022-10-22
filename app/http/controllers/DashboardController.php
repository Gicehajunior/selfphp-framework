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
    public $page;

    public function __construct()
    {
        $this->page = new Page();

        AuthMiddleware::AuthView();
    }

    public function index()
    {
        $this->page->View("resources/views", "dashboard");
    }
    
}
