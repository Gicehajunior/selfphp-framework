<?php

namespace SelfPhp; 

use SelfPhp\Path;  
    
class Route {

    public $routes;
    public static $controller_array;
    
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

    public static function get($route, $controller) { 
        Route::route_call("GET", $route, $controller);
    }

    public static function post($route, $controller) { 
        Route::route_call("POST", $route, $controller);
    }

    public static function put($route, $controller) { 
        Route::route_call("PUT", $route, $controller);
    }

    public static function delete($route, $controller) { 
        Route::route_call("`DELETE`", $route, $controller);
    } 

    public static function route_matcher_call($router) {  
        $match = $router->match();

        if($match && is_callable( $match['target'] )) {
            call_user_func_array( $match['target'], $match['params'] ); 
        }  
    }
}