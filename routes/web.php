<?php 
    // Router
    $router = new AltoRouter(); 

    require "./config/route_config.php";

    // home page route
    $router->map('GET', '/', route('HomeController', 'index'));
 
    //Add more routes here below
    /* code */
    









    $match = $router->match();
    if( $match && is_callable( $match['target'] ) ) {
        call_user_func_array( $match['target'], $match['params'] ); 
    } else {
        header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    }
