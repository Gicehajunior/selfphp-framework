<?php

namespace SimplePay\SimplePay;

class Database extends DatabaseModel {
    
    // get database connection
    public function getConnection(){
        
        $this->conn = null;
        
        try {
            $this->conn = mysqli_connect($this->servername, $this->dBUsername, $this->dBPassword, $this->dBName); 

            if (!$this->conn){
                die("Connection failed. Kindly Check your Internet Connection or Contact Customer Care.");
            }
            else{
                return $this->conn;
            }
        } catch (\mysqli_sql_exception $e) {
            throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
        }
    } 
}
