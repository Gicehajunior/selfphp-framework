<?php

namespace SelfPhp;

use AltoRouter;
use SelfPhp\Request;
use SelfPhp\SP;
use SelfPhp\Auth;

/**
 * Custom Path class extending AltoRouter
 * 
 * Handles routing and controller execution based on specified paths.
 */
class Path extends AltoRouter
{
    /**
     * @var string|null The controller to be executed.
     */
    public $controller;

    /**
     * @var string|null The callable function/method within the controller.
     */
    public $callable_function;

    /**
     * Constructor for the Path class.
     * 
     * @param string|null $controller The controller to be executed.
     * @param string|null $callable_function The callable function/method within the controller.
     */
    public function __construct($controller = null, $callable_function = null)
    {
        // Start session if not already active
        ($this->is_session_active() == true) ? null : session_start();

        $this->controller = $controller;
        $this->callable_function = $callable_function;
    }

    /**
     * Checks if the session is active.
     * 
     * @return bool Returns true if the session is active, false otherwise.
     */
    public function is_session_active()
    {
        // Check if running in a web environment
        if (php_sapi_name() !== 'cli') {
            // Check PHP version for session status
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    }

    /**
     * Static method to handle routing and controller execution.
     * 
     * @param string $controller The controller to be executed.
     * @param string $callable_function The callable function/method within the controller.
     * @return void
     */
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

            $data = null;

            // Return data from backend to frontend    
            if (isset($response)) {  
                $data = isset($response['controller_response_data']) 
                    ?   $response['controller_response_data'] 
                    :   $response;
            }  

            if (isset($response['view_url'])) { 
                if (file_exists($response['view_url'])) {    
                    echo $sp->fileParser($data, $response['view_url']); 
                    (new Path())->unsetSession();    
                    exit(); 
                } 
                else {
                    throw new \Exception("View path could not be found. You might have deleted the view, or the view path is incorrect.");
                }
            }    
            else {  
                (new Path())->alternative_callable_method_response($response, $sp); 
                (new Path())->unset_session(); 
            } 
        } catch (\Throwable $th) { 
            echo $th->getMessage();
        }
    }

    /**
     * Handles an alternative response when the controller response is not a view.
     * 
     * @param mixed $controllerResponse The response from the controller.
     * @param SP $sp The SP instance for utility functions.
     * @return void
     */
    public function alternative_callable_method_response($controllerResponse, $sp) { 
        if (is_array($controllerResponse)) {
            if (count($controllerResponse) > 0) {   
                echo $sp->serve_json($controllerResponse); 
                exit();  
            }
        }
    }


    /**
     * Unsets the controller response session.
     */
    public function unsetSession()
    { 
        if (isset($_SESSION['controller_response_data'])) {
            unset($_SESSION['controller_response_data']);
        }
    }

    /**
     * Retrieves the path of the specified controller.
     * 
     * @param string $controller The name of the controller.
     * @return string|null The path to the controller file or null if not found.
     */
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
