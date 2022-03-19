<?php

use SelfPhp\SP;
use SelfPhp\Page;
use SelfPhp\Auth;
use SelfPhp\Serve;
use App\http\middleware\AuthMiddleware;
use App\models\HomeModel;  

class HomeController extends SP
{
    public $page;

    public function __construct()
    {
        $this->page = new Page();
    }

    public function index()
    { 
        $this->page->View("resources", "home");
    }
}
