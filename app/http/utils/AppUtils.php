<?php

namespace SelfPhp;
namespace App\http\utils;  

use SelfPhp\database\Database; 
use SelfPhp\SP;
use SelfPhp\Serve;
use SelfPhp\Auth;

class AppUtils extends Serve
{

    public $db_connection;
    public $table;
    public $sessionObject;

    public function __construct($table)
    {
        $this->table = $table;
        $this->db_connection = new Database();
        $this->db_connection = $this->db_connection->connect();
        $this->sessionObject = Auth::UserSession();
    }
}