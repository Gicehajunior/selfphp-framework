<?php

use SelfPhp\SP;
use SelfPhp\Page;
use SelfPhp\Auth;
use SelfPhp\DB\Serve; 
use App\http\middleware\AuthMiddleware;
use App\models\HomeModel;  

class HomeController extends SP
{ 
    public function __construct()
    {
        
    }

    public function index()
    { 
        return view("home");
    }
}
