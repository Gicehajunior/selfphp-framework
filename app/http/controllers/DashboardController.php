<?php

use SelfPhp\SP;
use SelfPhp\Page;
use SelfPhp\Auth;
use SelfPhp\Serve; 
use App\models\DashboardModel;   

class DashboardController extends SP
{
    public $page;

    public function __construct()
    {
        $this->page = new Page();

        $this->page->AuthorizationMiddleware();
    }

    public function index()
    { 
        $this->page->View("resources/views", "dashboard");
    }
}
