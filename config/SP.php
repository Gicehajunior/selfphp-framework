<?php

namespace SelfPhp;  

class SP
{
    public $request; 

    public function __construct()
    {
        $this->request = null; 
    } 

    public function request($param)
    {
        return $_POST[$param];
    }

    public function request_config($config) {
        $config_file = require "./config/" . $config . '.php';

        return $config_file;
    }

    public static function init_sql_debug($db_connection) { 
        if ($_ENV['DEBUG'] == 'true' || $_ENV['DEBUG'] == 'True' || $_ENV['DEBUG'] == 'TRUE') {
            echo mysqli_error($db_connection);
            exit();
        }
    }

}
