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

            $sp->verify_domain_format(env("APP_DOMAIN"));

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
            if (isset($_SESSION['status'])) {   
                $response['data']['status'] = $_SESSION['status'];
                $_SESSION['controller_parsed_data']['status'] = $_SESSION['status'];
            } 
            
            if (isset($_SESSION['message'])) {   
                $response['data']['message'] = $_SESSION['message'];
                $_SESSION['controller_parsed_data']['message'] = $_SESSION['message'];
            } 

            if (isset($response['data']))
            {
                if (is_array($response['data'])) {
                    if (count($response['data']) > 0) {
                        $_SESSION['controller_parsed_data'] = $response['data'];
                        foreach ($response['data'] as $key => $value) { 
                            $$key = $value; 
                        }
                    }
                }
    
                if (isset($response['data'])) { 
                    extract($response['data']);
                } 
            }

            if (isset($response['view_url'])) { 
                if (file_exists($response['view_url'])) {  
                    echo $sp->file_parser($response['data'], $response['view_url']); 
                    unset($_SESSION['status']);
                    unset($_SESSION['message']); 
                    exit(); 
                } 
                else {
                    throw new \Exception("View path could not be found. You might have deleted the view, or the view path is incorrect.");
                }
            }    
            else {
                (new Path())->alternative_callable_method_response($response, $sp); 
            }
        } catch (\Throwable $th) { 
            echo $th->getMessage();
        }
    }

    public function alternative_callable_method_response($controllerResponse, $sp) { 
        if (is_array($controllerResponse)) {
            if (count($controllerResponse) > 0) {  
                unset($_SESSION['status']);
                unset($_SESSION['message']);
                echo $sp->serve_json($controllerResponse);
                exit();  
            }
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
