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
    /**
     * Initializes the application configurations
     * 
     * @return array of of configs.
     */
    public $app;

    public function __construct()
    {
        $this->app = $this->request_config("app"); 
    }

    /**
     * Include/require the config file
     * found from the config directory
     * 
     * @return config_file
     */
    public function request_config($config)
    {

        $config = ucfirst(strtolower($config));

        $config_file = require "./config/" . $config . '.php';

        return $config_file;
    }

    /**
     * Returns json format of an array to be 
     * served 
     * 
     * @return json
     */
    public function serve_json(array $data)
    {
        return json_encode($data);
    }

    /**
     * Setup configurations 
     * 
     * @return configurations
     */
    public function setup_config()
    {
        $this->request_config("config");
    }

    /**
     * @return AppName
     */
    public function app_name() {
        $app_name = ($this->env('APP_NAME')) 
            ?   $this->env('APP_NAME') 
            :   $this->app['APP_NAME'];
        
        return $app_name;
    }

    /**
     * Require app domain
     * 
     * @return array
     */
    public function domain() {
        return $this->app['APP_DOMAIN'];
    }

    /**
     * @return LoginPageName
     */
    public function login_page() {    
        return $this->app['AuthPage'];
    }

    /**
     * @return DashboardPageName
     */
    public function dashboard_page() {    
        return $this->app['HomePage'];
    }

    /**
     * @return env_variable
     */
    public function env($var_name)
    {
        try {
            return $_ENV[strtoupper($var_name)];
        } catch (\Throwable $error) {
            SP::debug_backtrace_show("EnvironmentVariableParameterException");
        }
    }

    public function verify_domain_format($domain=null)
    { 
        if (!empty($domain)) {
            if (strpos($domain, "http://") == false || strpos($domain, "https://") == false)
            {
                return $domain; 
            }    

            throw new \Exception("DomainFormatException: Domain must be in the format of http:// or https://");
        }  
    }

    /**
     * @return publicPath
     */
    public function public_path($path=null)
    {
        $path = ($this->env("APP_DOMAIN") 
            ?   $this->env("APP_DOMAIN") 
            :   $this->domain()) . "/public" . $path;

        return $path;
    }

    /**
     * @return assetPath
     */
    public function asset_path($path=null)
    { 
        $path = ($this->env("APP_DOMAIN") 
                    ?   $this->env("APP_DOMAIN") 
                    :   $this->domain()) . "/public/" . $path;

        return $path;
    }

    /**
     * @return storagePath
     */
    public function storage_path($path=null)
    {
        $path = ($this->env("APP_DOMAIN") 
            ?   $this->env("APP_DOMAIN") 
            :   $this->domain()) . "/public/storage/" . $path;

        return $path;
    }

    /**
     * Requires the included file
     * Parsed over to the running view
     * 
     * @return filePath
     */
    public function resource_path($view, $data=null)
    {
        $file_array = array();
        $resource_path = getcwd() . "/resources";
        
        $files = $this->scan_directory($resource_path);
        
        $end_name = null;
        $file_name = null;
        
        $view_path_array = explode(".", $view); 

        if (strtolower(end($view_path_array)) == "partial") {
            $end_name .= end($view_path_array);

            array_pop($view_path_array);

            $file_name .= end($view_path_array);

            array_pop($view_path_array);
        }
        else {
            $end_name = null;

            $file_name .= end($view_path_array);

            array_pop($view_path_array);
        }

        $dynamic_path = null;

        foreach ($view_path_array as $key => $view_path) {
            $dynamic_path .= $view_path . DIRECTORY_SEPARATOR;
        }

        $file_match_array = array();
        foreach ($files as $key => $folder) {  
            $file = glob($folder . DIRECTORY_SEPARATOR . $dynamic_path . $file_name . (($end_name == null) ? null : ("." . $end_name)) . ".php");
            
            if (count($file) > 0) {
                array_push($file_match_array, $file);
            }
        }

        $included_file_path = (isset($file_match_array[0]))     
            ?   array_unique($file_match_array[0])
            :   null;
        
        if (!empty($included_file_path)) { 
            $included_file = current($included_file_path); 
            echo $this->file_parser($data, $included_file);
        } 
        else {
            throw new \Exception("FileNotFoundException");
        } 
    }

    public function scan_directory($resource_path) {
        $files = array();
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($resource_path),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                array_push($files, $file->getRealpath());
            }
        }

        return $files;
    }

    /**
     * Parses html/php files with post data
     * 
     * @return parsed_data
     */
    public function file_parser($data=[], $filename = null) { 
        if (is_file($filename)) {
            if (is_array($data) && count($data)) {
                $controller_parsed_data = isset($_SESSION['controller_parsed_data']) 
                    ?   $_SESSION['controller_parsed_data'] 
                    :   null;
                
                if (is_array($controller_parsed_data)) {
                    if (count($controller_parsed_data) > 0) {
                        foreach ($controller_parsed_data as $key => $value) {   
                            $data[$key] = $value;
                        }
                    }
                } 

                extract($data);
            }
    
            ob_start(); 
            
            require($filename);
    
            return ob_get_clean();
        }

        unset($_SESSION['controller_parsed_data']);
        
        return false;
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
    public static function init_sql_debug($db_connection = null)
    {
        if (!empty((new SP())->env('DEBUG'))) {
            if (strtolower((new SP())->env('DEBUG')) == 'true') { 
                throw new \Exception(mysqli_error($db_connection)); 
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
    public static function debug_backtrace_show($exception = null)
    {
        if (!empty((new SP())->env('DEBUG'))) {
            if (strtolower((new SP())->env('DEBUG')) == 'true') {
                if (!empty($exception)) {
                    throw new \Exception($exception);
                    exit();
                } 
            }
        }
    }
}
