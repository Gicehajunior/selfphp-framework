<?php

namespace App\models;

use SelfPhp\DB\Serve;

class AuthModel extends Serve 
{
    
    protected static $table = "users";

    public function __construct()
    {
        
    }  
}


