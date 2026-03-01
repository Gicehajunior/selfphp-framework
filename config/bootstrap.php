<?php 

// Require SP DB Helper class.
use SelfPhp\SP;
use SelfPhp\Auth;
use SelfPhp\Page;
use SelfPhp\Route;
use SelfPhp\DB\Serve;
use SelfPhp\SPException;
use SelfPhp\TemplatingEngine\SPTemplateEngine;

$sp = new SP();

// Require Dotenv Class; To load environment variables.
$dotenv = Dotenv\Dotenv::createImmutable(getcwd());
$dotenv->load();

// Add DB.
$serve = new Serve();
$serve->addDBManager();

/**
 * Reads environment variable, considering redeclaration exemption
 * 
 * @param string $key The key of the environment variable.
 * @return string The value of the environment variable.
 */
if (!function_exists('env'))
{
    function env($key) {
        return $sp->env($key);
    }
}

/**
 * Global Configuration Loader 
 */  
$configFiles = glob(getcwd() . '/config/*.php');
$configArrays = array_map(function ($configFile) { 
    $config = [];
    if (basename($configFile) != 'bootstrap.php'){
        $config = include $configFile;
    }

    return is_array($config) ? $config : [];
}, $configFiles);

// Merge all arrays recursively so nested keys are preserved
$GLOBALS['config'] = array_reduce($configArrays, function ($carry, $item) {
    return array_replace_recursive($carry, $item);
}, []);

/**
 * Get all configuration for a group.
 *
 * @param string $group Configuration group (default 'app')
 * @return array Configuration array for the group
 */
function config_all() {
    return $GLOBALS['config'] ?? [];
}

/**
 * Get a specific configuration value.
 *
 * @param string $key Configuration key
 * @param string $group Configuration group (default 'app')
 * @return mixed|null Value if found, null otherwise
 */
function config($key) {
    return $GLOBALS['config'][$key] ?? null;
}

/**
 * Get a configuration value with parsing (optional).
 *
 * @param string $key Configuration key
 * @param string $group Configuration group (default 'app')
 * @return mixed|null Parsed value if found, null otherwise
 */
function config_parse($key) {
    $value = $GLOBALS['config'][$key] ?? null; 
    
    if (empty($value)) {
        return env($key);
    }

    return $value;
}

/**
 * Views the views passed. Accepts the file path of a view,
 * & Optional data array
 *
 * @param string $viewName The name of the view file (without .php).
 * @param array $data The array to extract and pass to the view.
 * @param bool $raw Whether to return the rendered view content as raw string.
 * @return string|void
 * @throws \Exception If the view is not found.
 */
function view($viewName, $data = [], $raw = false)
{
    // Replace dots with slashes except for the .php extension
    $viewName = preg_replace('/\.(?!php$)/', '/', $viewName);
    
    $directories = config('RESOURCE_VIEWS_DIRECTORY');

    if (!is_array($directories)) {
        $directories = [$directories];
    }
    
    // Locate the view file in the given directories
    $viewPath = null;
    foreach ($directories as $dir) {
        if (empty($dir)) continue; 
        $fullPath = getcwd() . DIRECTORY_SEPARATOR . rtrim($dir, '/') . DIRECTORY_SEPARATOR . $viewName . '.php';
        if (file_exists($fullPath)) {
            $viewPath = $fullPath;
            break;
        }
    }

    if (!$viewPath) {
        throw new SPException("View '{$viewName}' not found in any configured application views directory.", 500);
    }

    // Start output buffering
    ob_start();

    // Extract variables into current scope
    extract($data);

    // Include the view file
    include($viewPath);

    // Get the buffer contents
    $content = ob_get_clean();

    if ($raw) {
        return $content; // Return raw view content
    }
    
    $SPTemplatingEngine = new SPTemplateEngine($content);
    $SPTemplatingEngine->assignArray($data);

    // Return the parsed template content.
    echo $SPTemplatingEngine->render(); 
    exit; 
}


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
 * Determine and return the current route.
 *
 * @return string The current route (e.g. 'bootstrap4', 'bootstrap5')
 */
function current_route(): string { 
    return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: 'index';
}

/**
 * Determine the Bootstrap version to be used for the current route.
 *
 * @return string The bootstrap version (e.g. 'bootstrap4', 'bootstrap5')
 */
function bootstrap(): string {
    $config = config_parse('bootstrap'); 

    $defaultVersion = $config['default'] ?? '4';

    $routes = $config['routes'] ?? []; 

    // Get the current route/view.  
    $currentRoute = current_route(); 
    
    foreach ($routes as $version => $routeList) {
        if (in_array($currentRoute, $routeList) || in_array('*', $routeList)) {
            return $version;
        }
    }

    return $defaultVersion;
} 

/**
 * Retrieves the application name
 * 
 * @return string The application name.
 */
function sys_name() {
    $app_name = config_parse('APP_NAME');

    return $app_name;
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
 * @param array $data The data to be parsed.
 * @param string $filename The name of the file being parsed.
 * @return mixed The parsed data.
 */
function file_parser($data, $filename) {
    return (new SP())->fileParser($data, $filename);
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
function resource($filename, $data=[]) { 
    return (new SP())->resource($filename, $data);
}

/**
 * Redirects to the given route
 * 
 * @param string $route The route to navigate to.
 * @param array $data The data to be passed to the route.
 * @return bool
 */
function route($route, $data = []) {  
    $page = new Page(); 
    $view_response = $page->navigate_to($route, $data); 
    
    return $view_response;
}

/**
 * Redirects back to the previous route
 *  
 * @param array $data The data to be passed to the route.
 * @return bool
 */
function back($data = []) {  
    $page = new Page(); 
    $view_response = $page->back($data); 
    
    return $view_response;
}

function sp_error_logger($error, $error_code=0) { 
    try {
        $isDebug = (new SP())->debugMode();
        
        if ($isDebug) {
            throw new \Exception($error);
        } 

        return "An error occurred!";
    } catch (\Exception $err) {
        return "Error [{$err->getCode()}]: {$err->getMessage()} in {$err->getFile()} on line {$err->getLine()}";
    }
}

/**
 * ---------------------------------------------------------------
 * Application Route Registration & Dispatch
 * ---------------------------------------------------------------
 *
 * 1. Loads all route definition files from the configured ROUTE_PATH.
 * 2. Registers routes via Route::get(), post(), etc.
 * 3. Executes the router dispatcher once after all routes are mapped.
 *
 * Important:
 * - Routes MUST be registered before calling Route::dispatch().
 * - Dispatch should be called exactly once per request lifecycle.
 */
$route_path = config('ROUTE_PATH');
$routeFiles = glob($route_path . '/*.php');
foreach ($routeFiles as $file) {
    include $file;
}

Route::dispatch();
