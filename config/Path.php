<?php

namespace SelfPhp;

use AltoRouter;
use SelfPhp\Request;
use SelfPhp\SP;
use SelfPhp\Auth;

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
        try { 
            $path = new Path();

            $sp = new SP();

            $sp->setup_config();  

            $route = $path->controller_path($controller);
            
            if (isset($route)) {
                require $route;
            }
            else { 
                throw new \Exception($controller . " Controller not found");
            }
            $controller_class = new $controller();
            $response = $controller_class->$callable_function((new Request()));

            // Return data from backend to frontend
            if (isset($_SESSION['status']) || isset($_SESSION['message'])) {   
                $status = $_SESSION['status']; 
                $message = $_SESSION['message'];
            }   

            if (isset($response['data'])) { 
                extract($response['data']);
            }

            if (isset($response['view_url'])) {
                if (file_exists($response['view_url'])) { 
                    require $response['view_url'];
                } 
                else {
                    throw new \Exception((isset($response['view']) ? $response['view'] : null) . " View path could not be found. You might have deleted the view, or the view path is incorrect.");
                }
            } 
            else {
                throw new \Exception((isset($response['view']) ? $response['view'] : null) . " View path could not be found. You might have deleted the view, or the view path is incorrect.");
            }

            if (! isset($response['view'])) {
                throw new \Exception((isset($response['view']) ? $response['view'] : null) . " View not not be found");
            }

            unset($_SESSION['status']);
            unset($_SESSION['message']); 

        } catch (\Throwable $th) { 
            echo $th->getMessage();
        }
    }

    public function controller_path($controller)
    {
        $controllerPath = $GLOBALS['controllerPath'];

        $controller_found_array = array();

        foreach ($controllerPath as $controller_folder) {
            $controller_path = glob($controller_folder . DIRECTORY_SEPARATOR . $controller . '.php');

            if (count($controller_path) > 0) {
                array_push($controller_found_array, $controller_path);
            } 
        } 

        if (isset($controller_found_array[0][0]) && !empty($controller_found_array[0][0])) {
            return $controller_found_array[0][0];
        }  
        else if (isset($controller_found_array[1][0]) && !empty($controller_found_array[1][0])) {
            return $controller_found_array[1][0];
        } 
        else {
            return null;
        }
    }
}
