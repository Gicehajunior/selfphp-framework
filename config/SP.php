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
     * Process and get the files posted
     * from the frontend
     * 
     * @return post
     */
    public function file($param)
    {
        return $_FILES[$param];
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
     * Returns json format of an array to be 
     * served 
     * 
     * @return json
     */
    public function serve_json(array $data) {
        echo json_encode($data);
    }

    /**
     * Setup configurations 
     * 
     * @return configurations
     */
    public function setup_config() {
        $this->request_config("config"); 
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
    public static function init_sql_debug($db_connection = null) {
        if (!empty($_ENV['DEBUG'])) {
            if (strtolower($_ENV['DEBUG']) == 'true') {
                echo mysqli_error($db_connection); 
                exit();
            }
        }
    }

    /**
     * If debug is set to true, the system should raise exceptions 
     * whereas if, debug is set to false,  exceptions are never shown 
     * to the user.
     * 
     * if error, an exit() is called.
     * 
     * @return exceptions
     */
    public static function debug_backtrace_show($exception = null) {
        
        if (!empty($_ENV['DEBUG'])) {
            if (strtolower($_ENV['DEBUG']) == 'true') {
                echo ($exception ?? $exception);
                exit();
            }
        }
    }

}
