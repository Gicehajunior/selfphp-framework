<?php

use SelfPhp\SP;
use SelfPhp\Auth;
use SelfPhp\Page;

/**
 * Checks if Authenticated
 * 
 * @return bool
 */
function Authenticated() {  
    return Auth::auth();
}

/**
 * Returns session object
 * 
 * @return session
 */
function Auth($key) { 
    return Auth::User($key);
}

/**
 * conditional check if env function is declared to counter redeclaration exemption
 * 
 * Error is raised mostly when you try to use some frameworks composer packages & libraries 
 * for example, laravel composer packages & libraries, if you have declared the env function 
 * in your helper file and not checked if exists.
 */
if (!function_exists('env'))
{
    /**
     * Read environment variable
     * 
     * @return string
     */
    function env($key) {
        return (new SP())->env($key);
    }
}

/**
 * 
 * 
 * @return AppName
 */
function sys_name() {
    $app_name = (new SP())->env("APP_NAME");

    if (isset($app_name) && !empty($app_name)) {
        return (new SP())->env("APP_NAME");
    } else {
        return (new SP())->app_name(); 
    }
}

/**
 * @return publicPath
 */
function public_path($path) {
    return (new SP())->public_path($path);
}

/**
 * @return assetPath
 */
function asset_path($path) {
    return (new SP())->asset_path($path);
}

/**
 * @return storagePath
 */
function storage_path($path) {
    return (new SP())->storage_path($path);
}

/**
 * Reads domain set in the .env file
 * 
 * @return domain
 */
function sys_domain($var) {
    return (new SP())->env($var);
}

/**
 * Parses html/php files with post data
 * 
 * @return parsed_data
 */
function file_parser($data, $filename) {
    return (new SP())->file_parser($data, $filename);
}

/**
 * @return LoginPageName
 */
function login_page() {
    return (new SP())->login_page();
}

/**
 * @return DashboardPageName
 */
function dashboard_page() {
    return (new SP())->dashboard_page();
}

/**
 * Searches for file passed.
 * Requires the file parsed.
 * 
 * @return bool
 */
function page_extends($file, $data=null) {   
    $filecontent = (new SP())->resource($file, $data);

    echo $filecontent;
}

function view($view_dir, $data = []) {  
    $page = new Page();
    $response = [];
    $view_response = $page->View($view_dir, $data);

    $response['view_url'] = $view_response;  
    $response['data'] = $data;

    return $response;
}

function route($route, $data = []) {  
    $page = new Page(); 
    $page->navigate_to($route, $data);
}


