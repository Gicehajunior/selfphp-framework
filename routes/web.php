<?php
    /******************************************************************
     *  
     *  S.P. Framework v1.3.0
     *  --------------------------------------------------------------
     *  
     *  Welcome to the SelfPhp Framework, version 1.3.0!
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
     * @version 1.3.0
     * @license MIT License, https://github.com/Gicehajunior/selfphp-framework/blob/main/LICENSE
     *  
     *  --------------------------------------------------------------
     *                  ____________________________________
     * 
     */
    use SelfPhp\Route;
    use App\Http\Auth\AuthController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\HomeController;
    use App\Http\Middlewares\AuthMiddleware;
    
    // Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/auth', [AuthController::class, 'legacyLogin']);
    
    // NEW ROUTES
    Route::get('/e/login', [AuthController::class, 'login']); 
    Route::get('/e/register', [AuthController::class, 'signup']);

    // OLD ROUTES
    Route::get('/l/login', [AuthController::class, 'legacyLogin']); 
    Route::get('/l/register', [AuthController::class, 'legacyRegister']);

    Route::post('/login', [AuthController::class, 'login_user']); 
    Route::post('/register', [AuthController::class, 'signup_user']);
    
    Route::get('/logout', [AuthController::class, 'logout']); 
    Route::get('/404', [AuthController::class, 'notFoundErrorPage']); 