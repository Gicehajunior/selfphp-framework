<?php

use SelfPhp\SP;
use SelfPhp\Auth;

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
function public_path() {
    return (new SP())->public_path();
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
function storage_path() {
    return (new SP())->storage_path();
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
function page_extends($file) {
    
    return (new SP())->resource_path($file);
}




