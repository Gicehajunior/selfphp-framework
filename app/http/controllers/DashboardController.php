<?php

use SelfPhp\SP;
use SelfPhp\Page;
use SelfPhp\Auth;
use SelfPhp\Serve;
use App\http\middleware\AuthMiddleware;
use App\models\DashboardModel;   

class DashboardController extends SP
{  
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
