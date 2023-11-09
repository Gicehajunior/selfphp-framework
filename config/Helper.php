<?php

use SelfPhp\SP;
use SelfPhp\Auth;
use SelfPhp\Page;

/**
 * Checks if the user is authenticated
 * 
 * @return bool Returns true if authenticated, false otherwise.
 */
function Authenticated() {  
    return Auth::auth();
}

/**
 * Returns the user session object based on the provided key
 * 
 * @param string $key The key to retrieve from the user session.
 * @return mixed The value stored in the user session for the provided key.
 */
function Auth($key) { 
    return Auth::User($key);
}

/**
 * Reads environment variable, considering redeclaration exemption
 * 
 * @param string $key The key of the environment variable.
 * @return string The value of the environment variable.
 */
if (!function_exists('env'))
{
    function env($key) {
        return (new SP())->env($key);
    }
}

/**
 * Retrieves the application name
 * 
 * @return string The application name.
 */
function sys_name() {
    $app_name = (new SP())->env("APP_NAME");

    if (isset($app_name) && !empty($app_name)) {
        return $app_name;
    } else {
        return (new SP())->app_name(); 
    }
}

/**
 * Retrieves the public path of the application
 * 
 * @param string $path The path to append to the public path.
 * @return string The full public path including the provided path.
 */
function public_path($path) {
    return (new SP())->public_path($path);
}

/**
 * Retrieves the asset path of the application
 * 
 * @param string $path The path to append to the asset path.
 * @return string The full asset path including the provided path.
 */
function asset_path($path) {
    return (new SP())->asset_path($path);
}

/**
 * Retrieves the storage path of the application
 * 
 * @param string $path The path to append to the storage path.
 * @return string The full storage path including the provided path.
 */
function storage_path($path) {
    return (new SP())->storage_path($path);
}

/**
 * Reads the domain set in the .env file
 * 
 * @param string $var The key of the domain variable.
 * @return string The value of the domain variable.
 */
function sys_domain($var) {
    return (new SP())->env($var);
}

/**
 * Parses HTML/PHP files with post data
 * 
 * @param string $data The data to be parsed.
 * @param string $filename The name of the file being parsed.
 * @return mixed The parsed data.
 */
function file_parser($data, $filename) {
    return (new SP())->file_parser($data, $filename);
}

/**
 * Retrieves the set application login page route
 * 
 * @return string The login page route.
 */
function login_page() {
    return (new SP())->login_page();
}

/**
 * Retrieves the set application dashboard page route
 * 
 * @return string The dashboard page route.
 */
function dashboard_page() {
    return (new SP())->dashboard_page();
}

/**
 * Searches for the file passed, requires the file to be parsed
 * 
 * @param string $file The name of the file to extend.
 * @param mixed $data The data to be passed to the extended file.
 * @return mixed The content of the extended file.
 */
function page_extends($file, $data=null) {   
    $filecontent = (new SP())->resource($file, $data);

    echo $filecontent;
}

/**
 * Redirects and views the given view file
 * 
 * @param string $view_dir The directory of the view file.
 * @param array $controller_response_data The data to be passed to the view file.
 * @return array The view URL and data.
 */
function view($view_dir, $data = []) {  
    $page = new Page();
    $response = [];
    $view_response = $page->View($view_dir, $data);

    $response['view_url'] = $view_response;  
    $response['controller_response_data'] = $data;

    return $response;
}

/**
 * Redirects to the given route
 * 
 * @param string $route The route to navigate to.
 * @param array $data The data to be passed to the route.
 * @return void
 */
function route($route, $data = []) {  
    $page = new Page(); 
    $page->navigate_to($route, $data);
}
