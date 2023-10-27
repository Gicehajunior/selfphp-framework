<?php

namespace SelfPhp;
use SelfPhp\SP; 

class Request {   

    public $get; 
    public $http_requests = [];

    public function __construct()
    { 
        $this->get = $this->requests();  
    }

    public function requests() {
        $requestObject = $this->set_http_requests();

        return (Object) $requestObject;
    } 

    public function appConfig(){ 
        $Request = (new SP())->request_config("app");

        return $Request;
    }

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

    public function combine_req_array_values(array $multi_dim_array) { 
        foreach ($multi_dim_array as $key => $array) { 
            foreach($array as $sub_key => $sub_value) {
                $this->http_requests[$sub_key] = $sub_value;
            } 
        }  
    }
    
}
