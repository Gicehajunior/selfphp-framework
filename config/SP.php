<?php

namespace SelfPhp;

/**
 * Class acts as main controller for the whole application. 
 * 
 * Resources and asset handling for the application do happens here. 
 * Controllers and Models classes extends this class.
 *
 * @copyright  2022 SelfPHP Framework Technology
 * @license    https://github.com/Gicehajunior/selfphp-framework/blob/main/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/Gicehajunior/selfphp-framework/blob/main/config/SP.php
 * @since      Class available since Release 1.0.0
 */ 
class SP
{
    public $request; 

    public function __construct()
    {
        $this->request = null; 
    } 

    /**
     * Process and get the post request values
     * from the frontend
     * 
     * @return post
     */
    public function request($param)
    {
        return $_POST[$param];
    }

    /**
     * Include/require the config file
     * found from the config directory
     * 
     * @return config_file
     */
    public function request_config($config) {
        $config_file = require "./config/" . $config . '.php';

        return $config_file;
    }

    /**
     * If debug is set true, the system sql commands 
     * should show errors whereas if, debug is set to false, 
     * sql commands never shows/produces debugging statements.
     * 
     * if error, an exit() is called.
     * 
     * @return mysqli_error
     */
    public static function init_sql_debug($db_connection) { 
        if ($_ENV['DEBUG'] == 'true' || $_ENV['DEBUG'] == 'True' || $_ENV['DEBUG'] == 'TRUE') {
            echo mysqli_error($db_connection);
            exit();
        }
    }

}
