<?php

    use SelfPhp\Route;


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
    Route::get('/', 'HomeController@index');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/login', 'AuthController@login');
    Route::get('/register', 'AuthController@signup');

    Route::post('/login', 'AuthController@login_user'); 
    Route::post('/register', 'AuthController@signup_user');
    
    Route::get('/logout', 'AuthController@logout'); 
