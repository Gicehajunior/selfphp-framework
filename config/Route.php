<?php

namespace SelfPhp; 

use SelfPhp\Path;  
    
class Route {

    public $routes;
    public static $controller_method_array;
    
    public static function route_call($route_method, $route, $controller_method) {  
        if (isset($route) || isset($controller_method)) { 

            $controller_method_array = explode("@", $controller_method);  

            Route::$controller_method_array = $controller_method_array;

            $router = new Path(); 

            $router->map($route_method, $route, function (){
                Path::route(Route::$controller_method_array[0], Route::$controller_method_array[1]);
            }); 

            if (!method_exists("Route", "route_matcher_call")) {
                Route::route_matcher_call($router);
            }
        }
        else {
            echo "Corrupt route or route refused to parse!";
        }
        
    } 

    public static function get($route, $controller_method) { 
        Route::route_call("GET", $route, $controller_method);
    }

    public static function post($route, $controller_method) { 
        Route::route_call("POST", $route, $controller_method);
    }

    public static function put($route, $controller_method) { 
        Route::route_call("PUT", $route, $controller_method);
    }

    public static function delete($route, $controller_method) { 
        Route::route_call("`DELETE`", $route, $controller_method);
    } 

    public static function route_matcher_call($router) {  
        $match = $router->match();

        if($match && is_callable( $match['target'] )) {
            call_user_func_array( $match['target'], $match['params'] ); 
        }  
    }
}