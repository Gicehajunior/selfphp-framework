<?php

namespace SelfPhp;  
use SelfPhp\Path;  
    
/**
 * Class Route
 * 
 * Handles routing for various HTTP methods and calls the associated controllers.
 */
class Route {

    /**
     * @var array The routes to be registered.
     */
    public $routes;

    /**
     * @var array The controller array containing controller and method names.
     */
    public static $controller_array;

    /**
     * Handles the routing call for a specified HTTP method and route.
     * 
     * @param string $route_method The HTTP method for the route (GET, POST, PUT, DELETE).
     * @param string $route The route to be registered.
     * @param string $controller The controller and method names to be called.
     * @return void
     */
    public static function route_call($route_method, $route, $controller) {  
        if (isset($route) || isset($controller)) { 

            $controller_array = explode("@", $controller);  

            Route::$controller_array = $controller_array;

            $router = new Path(); 

            $router->map($route_method, $route, function (){
                Path::route(Route::$controller_array[0], Route::$controller_array[1]);
            }); 

            if (!method_exists("Route", "route_matcher_call")) {
                Route::route_matcher_call($router);
            }
        }
        else {
            echo "Corrupt route or route refused to parse!";
        }
    } 

    /**
     * Registers a GET route.
     * 
     * @param string $route The route to be registered.
     * @param string $controller The controller and method names to be called.
     * @return void
     */
    public static function get($route, $controller) { 
        Route::route_call("GET", $route, $controller);
    }

    /**
     * Registers a POST route.
     * 
     * @param string $route The route to be registered.
     * @param string $controller The controller and method names to be called.
     * @return void
     */
    public static function post($route, $controller) { 
        Route::route_call("POST", $route, $controller);
    }

    /**
     * Registers a PUT route.
     * 
     * @param string $route The route to be registered.
     * @param string $controller The controller and method names to be called.
     * @return void
     */
    public static function put($route, $controller) { 
        Route::route_call("PUT", $route, $controller);
    }

    /**
     * Registers a DELETE route.
     * 
     * @param string $route The route to be registered.
     * @param string $controller The controller and method names to be called.
     * @return void
     */
    public static function delete($route, $controller) { 
        Route::route_call("`DELETE`", $route, $controller);
    } 

    /**
     * Calls the route matcher for handling matched routes.
     * 
     * @param Path $router The Path instance for routing.
     * @return void
     */
    public static function route_matcher_call($router) {  
        $match = $router->match();

        if($match && is_callable( $match['target'] )) {
            call_user_func_array( $match['target'], $match['params'] ); 
        }  
    }
}
