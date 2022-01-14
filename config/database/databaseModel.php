<?php 

use SimplePay\SimplePay\Database;

class DatabaseModel extends Database{
    
    private $servername;
    private $dBName;
    private $dBUsername;
    private $dBPassword;
    public $conn;
    
    public function __construct($database_host, $database_name, $database_username, $database_password){
        $this->servername = $database_host;
        $this->dBName = $database_name;
        $this->dBUsername = $database_username;
        $this->dBPassword = $database_password;
    }

}