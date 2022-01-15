<?php 
    require "./config/route_config.php";

    // Router
    $router = new AltoRouter(); 

    // home page route
    $router->map('GET', '/', function () {
        route('HomeController', 'index');
    });
 
    //Add more routes here below
    
    // auth routes
    $router->map('GET', '/login', function () {
        route('AuthController', 'login');
    });
 
    $router->map('GET', '/register', function () {
        route('AuthController', 'signup');
    });
 
    







    $match = $router->match();
    if( $match && is_callable( $match['target'] ) ) {
        call_user_func_array( $match['target'], $match['params'] ); 
    } else {
        header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    }
