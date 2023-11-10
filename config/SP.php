<?php

namespace SelfPhp;

use SelfPhp\TemplatingEngine\SPTemplateEngine;

/**
 * The SP class acts as the main controller for the entire application, handling 
 * resources, asset management, and serving as the base for controllers and models.
 *
 * @copyright  2022 SelfPHP Framework Technology
 * @license    https://github.com/Gicehajunior/selfphp-framework/blob/main/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/Gicehajunior/selfphp-framework/blob/main/config/SP.php
 * @since      Class available since Release 1.0.0
 */
class SP
{  
    /**
     * Holds the application configurations.
     *
     * @var object
     */
    public $app; 

    /**
     * Initializes the SP class, loading application configurations.
     *
     * @return void
     */
    public function __construct()
    { 
        $this->app = (Object) $this->request_config("app"); 
    }

    /**
     * Requests and returns a specified configuration file.
     *
     * @param string $config The configuration file to request.
     * @return mixed The requested configuration file.
     */
    public function request_config($config)
    {
        $config = ucfirst(strtolower($config));
        $config_file = require "./config/" . $config . '.php';
        return $config_file;
    }

    /**
     * Returns a JSON-encoded representation of an array.
     *
     * @param array $data The data to be encoded.
     * @return string JSON-encoded data.
     */
    public function serve_json(array $data)
    {
        return json_encode($data);
    }

    /**
     * Set up configurations.
     *
     * @return void
     */
    public function setup_config()
    {
        $this->request_config("config");
    }

    /**
     * Retrieves the value of an environment variable.
     *
     * @param string $var_name The name of the environment variable.
     * @return mixed The value of the environment variable.
     */
    public function env($var_name)
    {
        return isset($_ENV[strtoupper($var_name)]) ? $_ENV[strtoupper($var_name)] : '{{ ' . $var_name . " is not set in the .env file. }}";
    }

    /**
     * Gets the application name.
     *
     * @return string The application name.
     */
    public function app_name() {
        $app_name = $this->env("APP_NAME");

        if (isset($app_name) && !empty($app_name) && $app_name !== "{{ APP_NAME is not set in the .env file. }}") {
            return $this->env("APP_NAME");
        } else {
            return $this->app->APP_NAME;
        }   
    }

    /**
     * Retrieves the application domain.
     *
     * @return string|null The application domain.
     */
    public function domain() {
        return isset($this->app->APP_DOMAIN) ? $this->app->APP_DOMAIN : null;
    } 
        /**
     * Retrieves the login page name.
     *
     * @return string|null The login page name.
     */
    public function login_page() {    
        return isset($this->app->AuthPage) ? $this->app->AuthPage : null;
    }

    /**
     * Retrieves the dashboard page name.
     *
     * @return string|null The dashboard page name.
     */
    public function dashboard_page() {    
        return isset($this->app->HomePage) ? $this->app->HomePage : null;
    }

    /**
     * Verifies the format of the provided domain.
     *
     * @param string|null $domain The domain to be verified.
     * @throws \Exception if the domain format is invalid.
     * @return string|null The verified domain.
     */
    public function verify_domain_format($domain=null)
    { 
        if (!empty($domain)) {
            if (strpos($domain, "http://") == false || strpos($domain, "https://") == false)
            {
                return $domain; 
            }    

            throw new \Exception("DomainFormatException: Domain must be in the format of http:// or https://");
        }  
    }

    /**
     * Constructs the public path by appending the path to the application domain.
     *
     * @param string|null $path The path to be appended.
     * @return string The constructed public path.
     */
    public function public_path($path=null)
    {
        $path = ($this->env("APP_DOMAIN") ? $this->env("APP_DOMAIN") : $this->domain()) . DIRECTORY_SEPARATOR . $this->app->PUBLIC_PATH . DIRECTORY_SEPARATOR . $path;
        return $path;
    }

    /**
     * Constructs the asset path by appending the path to the application domain.
     *
     * @param string|null $path The path to be appended.
     * @return string The constructed asset path.
     */
    public function asset_path($path=null)
    { 
        $path = ($this->env("APP_DOMAIN") ? $this->env("APP_DOMAIN") : $this->domain()) . DIRECTORY_SEPARATOR . $this->app->PUBLIC_PATH . DIRECTORY_SEPARATOR . $path;
        return $path;
    }

    /**
     * Constructs the storage path by appending the path to the application domain.
     *
     * @param string|null $path The path to be appended.
     * @return string The constructed storage path.
     */
    public function storage_path($path=null)
    {
        $path = ($this->env("APP_DOMAIN") ? $this->env("APP_DOMAIN") : $this->domain()) . DIRECTORY_SEPARATOR . $this->app->STORAGE_PATH . DIRECTORY_SEPARATOR . $path;
        return $path;
    }

    /**
     * Requires and parses a view file, providing the data to be used.
     *
     * @param string $view The name of the view file.
     * @param array $data The data to be used in the view.
     * @return string The parsed view content.
     * @throws \Exception if the view file is not found.
     */
    public function resource($view, $data=[])
    { 
        $fileArray = array();
        $resourcePath = getcwd() . DIRECTORY_SEPARATOR . $this->app->RESOURCE_VIEWS_DIRECTORY;
        
        $files = $this->scanDirectory($resourcePath);
        
        $endName = null;
        $fileName = null;
        
        $viewPathArray = explode(".", $view); 

        if (strtolower(end($viewPathArray)) == "partial") {
            $endName .= end($viewPathArray);

            array_pop($viewPathArray);

            $fileName .= end($viewPathArray);

            array_pop($viewPathArray);
        }
        else {
            $endName = null;

            $fileName .= end($viewPathArray);

            array_pop($viewPathArray);
        }

        $dynamicPath = null;

        foreach ($viewPathArray as $key => $viewPath) {
            $dynamicPath .= $viewPath . DIRECTORY_SEPARATOR;
        }

        $fileMatchArray = array();
        foreach ($files as $key => $folder) {  
            $file = glob($folder . DIRECTORY_SEPARATOR . $dynamicPath . $fileName . (($endName == null) ? null : ("." . $endName)) . ".php");
            
            if (count($file) > 0) {
                array_push($fileMatchArray, $file);
            }
        }

        $includedFilePath = (isset($fileMatchArray[0])) ? array_unique($fileMatchArray[0]) : null;
        
        if (!empty($includedFilePath)) { 
            $includedFile = current($includedFilePath); 
            $controllerParsedData = isset($_SESSION['controller_response_data']) ? $_SESSION['controller_response_data'] : null;
            
            if (is_array($controllerParsedData)) {
                if (count($controllerParsedData) > 0) {
                    foreach ($controllerParsedData as $key => $value) {   
                        $data[$key] = $value;
                    }
                }
            }  

            return $this->fileParser($data, $includedFile);
        } 
        else {
            throw new \Exception("FileNotFoundException");
        } 
    }

    /**
     * Scans a directory and returns an array of file paths.
     *
     * @param string $resource_path The path to the directory to be scanned.
     * @return array An array of file paths.
     */
    public function scanDirectory($resourcePath) {
        $files = array();
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($resourcePath),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                array_push($files, $file->getRealpath());
            }
        }

        return $files;
    }

    /**
     * Parses HTML/PHP files with post data.
     *
     * @param array $data The data to be used in the parsed file.
     * @param string|null $filename The name of the file to be parsed.
     * @return string|false The parsed file content.
     */
    public function fileParser($data=[], $filename = null) { 
        
        // If the data is an array and is empty, 
        // then the data is set to the session data.
        // Otherwise, the session data is set to the data. 
        // By doing so, this will distribute the data to the extended pages.
        if (is_array($data) && count($data) == 0) {
            $data = isset($_SESSION['controller_response_data']) ? $_SESSION['controller_response_data'] : null;
        } 
        else {
            $_SESSION['controller_response_data'] = $data;
        } 

        // Perform the extraction of the data, and require 
        // the full page respectively. 
        if (is_file($filename)) {
            if (is_array($data) && count($data) > 0) {  
                extract($data);
            }
            
            ob_start();  

            require($filename);

            $htmlcontent = ob_get_clean();

            $SPTemplatingEngine = new SPTemplateEngine($htmlcontent);
            $SPTemplatingEngine->assignArray($data);

            // Return the parsed template content.
            return $SPTemplatingEngine->render();
        }
        
        return false;
    }

    /**
     * Converts CSV file data to an associative array.
     *
     * @param string $filepath The path to the CSV file.
     * @param int $MAX_LENGTH The maximum number of rows to read from the CSV file.
     * @return array|null An associative array representing the CSV data.
     */
    public static function csvToArray($filepath, $maxLength = 1000) {
        $csv = array();
        
        try {
            $count = 0;
            $reader = fopen($filepath, "r");

            if ($reader !== false) { 
                $headerCellValues = fgetcsv($reader);
                $headerColumnCount = count($headerCellValues);
                
                while (!feof($reader)) { 
                    $row = fgetcsv($reader);
                    
                    if ($row !== false && !empty(array_filter($row))) {
                        $count++; 
                        $rowColumnCount = count($row);
                        
                        if ($rowColumnCount == $headerColumnCount) {
                            $entry = array_combine($headerCellValues, $row);
                            $csv[] = $entry; 
                        } 
                        else {
                            return null;
                        } 

                        if ($count == $maxLength) {
                            break;
                        }
                    } 
                }
                fclose($reader);
            } 

            return $csv;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Moves and stores a file in the application's storage directory.
     *
     * @param array $fileMetadata The metadata of the file.
     * @param string $path The storage path for the file.
     * @return string The final destination path of the stored file.
     */
    public static function storageAdd($fileMetadata, $path)
    {
        try {
            $baseStoragePath = getcwd() . DIRECTORY_SEPARATOR . $this->app->STORAGE_PATH;

            if (substr($path, 1) === "/") {
                $storagePath = $baseStoragePath . $path;
            }
            else {
                $storagePath = $baseStoragePath . DIRECTORY_SEPARATOR . $path;
            }
    
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }
    
            $fileName = $fileMetadata['name'];
            $fileTmp = $fileMetadata['tmp_name'];
            $fileSize = $fileMetadata['size'];
            $fileError = $fileMetadata['error'];
            $fileType = $fileMetadata['type']; 
            
            // Move the uploaded file to the storage path.
            if (substr($storagePath, -1) === "/") {
                $currentUpload = $storagePath . $fileName;
            }
            else {
                $currentUpload = $storagePath . DIRECTORY_SEPARATOR . $fileName;
            }

            // If the file exists on path, delete it, and replace it with the new one.
            if (file_exists($currentUpload)) {
                unlink($currentUpload);
            }
            
            $fileDestination = $currentUpload;
            move_uploaded_file($fileTmp, $fileDestination);
    
            return $fileDestination;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Initializes SQL debugging based on the DEBUG environment variable.
     *
     * @param mysqli $db_connection The database connection object.
     * @throws \Exception if DEBUG is set to true and there is a MySQL error.
     */
    public static function initSqlDebug($dbConnection = null)
    {
        if (!empty((new SP())->env('DEBUG'))) {
            if (strtolower((new SP())->env('DEBUG')) == 'true') { 
                throw new \Exception(mysqli_error($dbConnection)); 
                exit();
            }
        }
    }

    /**
     * Shows debug backtrace based on the DEBUG environment variable.
     *
     * @param string|null $exception The exception message to be thrown.
     * @throws \Exception if DEBUG is set to true and there is an exception.
     */
    public static function debugBacktraceShow($exception = null)
    {
        if (!empty((new SP())->env('DEBUG'))) {
            if (strtolower((new SP())->env('DEBUG')) == 'true') {
                if (!empty($exception)) {
                    throw new \Exception($exception);
                    exit();
                } 
            }
        }
    }
}
