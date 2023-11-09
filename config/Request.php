<?php

namespace SelfPhp;
use SelfPhp\SP; 

/**
 * Class Request
 * 
 * Handles and provides access to various request data such as GET, POST, FILES, etc.
 */
class Request {   

    /**
     * @var array The GET request data.
     */
    public $get; 

    /**
     * @var array The combined HTTP request data.
     */
    public $http_requests = [];

    /**
     * Constructor for the Request class.
     * 
     * Initializes the GET request data and sets up the combined HTTP request data.
     */
    public function __construct()
    { 
        $this->get = $this->requests();  
    }

    /**
     * Retrieves the application configuration.
     * 
     * @return mixed The application configuration.
     */
    public function appConfig(){ 
        $Request = (new SP())->request_config("app");

        return $Request;
    }

    /**
     * Sets up the combined HTTP request data.
     * 
     * @return array The combined HTTP request data.
     */
    public function requests() {
        $requestObject = $this->set_http_requests();

        return (Object) $requestObject;
    } 

    /**
     * Retrieves the application configuration and combines various request arrays.
     * 
     * @return array The combined HTTP request data.
     */
    public function set_http_requests() {
        $app_configurations = $this->appConfig();

        if (isset($_SERVER['REQUEST_METHOD']))
        {
            if (isset($_POST)) {
                $this->combine_req_array_values([$app_configurations, $_POST]); 
            } 
            
            if (isset($_GET)) {
                $this->combine_req_array_values([$app_configurations, $_GET]); 
            } 
            
            if (isset($_FILES)) { 
                $this->combine_req_array_values([$app_configurations, $_FILES]); 
            } 
            
            if (isset($_REQUEST)) {
                $this->combine_req_array_values([$app_configurations, $_REQUEST]); 
            } 
            
            if (isset($_SERVER)) {
                $this->combine_req_array_values([$app_configurations, $_SERVER]); 
            } 
            
            if (isset($_ENV)) {  
                $this->combine_req_array_values([$app_configurations, $_ENV]);
            } 
        }
        
        return $this->http_requests;
    }

    /**
     * Combines values from multiple arrays into a single array.
     * 
     * @param array $multi_dim_array An array containing arrays to be combined.
     * @return void
     */
    public function combine_req_array_values(array $multi_dim_array) { 
        foreach ($multi_dim_array as $key => $array) { 
            foreach($array as $sub_key => $sub_value) {
                $this->http_requests[$sub_key] = $sub_value;
            } 
        }  
    }
    
}
