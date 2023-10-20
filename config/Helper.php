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
 * Read environment variable
 * 
 * @return string
 */
function env($key) {
    return (new SP())->env($key);
}

/**
 * 
 * 
 * @return AppName
 */
function app_name() {
    return ((new SP())->env("APP_NAME")) 
        ?   (new SP())->env("APP_NAME") 
        :   ((new SP())->app_name());
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
    return (new SP())->resource_path($file, $data);
}

function view($view_dir, $view, $data = []) {  
    $page = new Page();
    $response = [];
    $view_response = $page->View($view_dir, $view, $data);

    $response['view_url'] = $view_response; 
    $response['view'] = $view;
    $response['data'] = $data;

    return $response;
}

function route($route, $data = []) {  
    $page = new Page(); 
    $page->navigate_to($route, $data);
}


