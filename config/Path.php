<?php

require "./config/Page.php";
require "./config/Serve.php";
require "./config/Auth.php";
require "./config/selfphp.php";

class Path extends AltoRouter
{
    public $controller;
    public $callable_function;

    public function __construct($controller = null, $callable_function = null)
    {

        ($this->is_session_active() == true) ? null : session_start();


        $this->controller = $controller;
        $this->callable_function = $callable_function;
    }

    /**
     * @return bool
     */
    public function is_session_active()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    }


    public static function route($controller, $callable_function)
    {
        $path = new Path();

        require $path->controller_path($controller);

        $controller_class = new $controller();
        $controller_class->$callable_function();
    }

    public function controller_path($controller)
    {
        $controllerPath = $GLOBALS['controllerPath'];

        $controller_found_array = array();

        foreach ($controllerPath as $controller_folder) {
            $controller_path = glob($controller_folder . DIRECTORY_SEPARATOR . $controller . '.php');

            array_push($controller_found_array, $controller_path);
        }

        return ($controller_found_array[0][0]) ? $controller_found_array[0][0] : $controller_found_array[1][0];
    }
}
