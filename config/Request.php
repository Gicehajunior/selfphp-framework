<?php

namespace SelfPhp;
use SelfPhp\SP; 

class Request {   

    public $get; 

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
        if (isset($_POST)) { 
            $app_configurations = $this->appConfig();

            $http_request = $this->append_array_values([$app_configurations, $_POST]);

            return $http_request;
        } 
    }

    public function append_array_values(array $multi_dim_array) {
        $http_requests = array();

        foreach ($multi_dim_array as $key => $array) { 
            foreach($array as $sub_key => $sub_value) {
                $http_requests[$sub_key] = $sub_value;
            } 
        } 

        return $http_requests;
    }
    
}
