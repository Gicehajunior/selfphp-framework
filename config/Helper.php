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
 * 
 * 
 * @return AppName
 */
function app_name() {
    return (SP::env("APP_NAME")) 
        ?   SP::env("APP_NAME") 
        :   "Self PHP";
}

/**
 * @return publicPath
 */
function public_path() {
    return SP::public_path();
}

/**
 * @return assetPath
 */
function asset_path($path) {
    return SP::asset_path($path);
}

/**
 * @return storagePath
 */
function storage_path() {
    return SP::storage_path();
}

/**
 * Reads domain set in the .env file
 * 
 * @return domain
 */
function sys_domain($var) {
    return SP::env($var);
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




