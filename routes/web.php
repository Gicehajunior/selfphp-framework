<?php

    require "./config/route_config.php"; 
    
    // Router
    $router = new AltoRouter(); 

    /******************************************************************
     *  
     *                  ____________________________________
     * 
     * 
     *                      S.P. Framework v1.0
     * 
     *                  ____________________________________                        
     * 
     */

    /********************************
     * 
     * START OF ROUTES
     * ___________________________________________________________
     */
    // home page route
    $router->map('GET', '/', function () {
        Path::route('HomeController', 'index');
    });

    // Dashboard/Home
    $router->map('GET', '/dashboard', function () {
        Path::route('DashboardController', 'index');
    });
  
  
    // auth routes
    $router->map('GET', '/login', function () {
        Path::route('AuthController', 'login');
    });
 
    $router->map('GET', '/register', function () {
        Path::route('AuthController', 'signup');
    });

    $router->map('POST', '/login', function () {
        Path::route('AuthController', 'login_user');
    });

    $router->map('POST', '/register', function () {
        Path::route('AuthController', 'signup_user');
    });

    //Add more routes here below

    



    /***************
     * 
     *  END OF ROUTES
     * ____________________________________________________________________
     */

    $match = $router->match();
    if( $match && is_callable( $match['target'] ) ) {
        call_user_func_array( $match['target'], $match['params'] ); 
    } else {
        header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    }
