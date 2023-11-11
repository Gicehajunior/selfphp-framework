<?php

    use SelfPhp\Route;

    /******************************************************************
     *  
     *  S.P. Framework v1.0.0
     *  --------------------------------------------------------------
     *  
     *  Welcome to the SelfPhp Framework, version 1.0.0!
     *  
     *  This framework is designed to streamline the development process
     *  by providing a robust routing system. Use the 'Route' class to
     *  define and manage your application's routes effortlessly.
     *  
     *  Explore the power of S.P. Framework to create scalable and
     *  maintainable web applications with ease.
     *  
     *  For documentation and examples, visit: https://github.com/Gicehajunior/selfphp-framework.git
     * 
     * @author Giceha Junior, https://github.com/Gicehajunior
     * @version 1.0.0
     * @license MIT License, https://github.com/Gicehajunior/selfphp-framework/blob/main/LICENSE
     *  
     *  --------------------------------------------------------------
     *                  ____________________________________
     * 
     */
    
    Route::get('/', 'HomeController@index');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/login', 'AuthController@login');
    Route::get('/register', 'AuthController@signup');

    Route::post('/login', 'AuthController@login_user'); 
    Route::post('/register', 'AuthController@signup_user');
    
    Route::get('/logout', 'AuthController@logout'); 
