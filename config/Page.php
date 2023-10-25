<?php

namespace SelfPhp; 

use SelfPhp\SP;
use SelfPhp\Auth;

class Page extends SP
{
    public $RootDir;
    public $dotenv;
    public $status;
    public $message;

    public $route;

    public function __construct()
    {
        $this->RootDir = $GLOBALS['RootDir'];
    }

    public function View($view_folder_name, $data = null)
    { 
        $filepath = getcwd() . DIRECTORY_SEPARATOR . "resources/" . str_replace(".", "/", $view_folder_name); 
        $files = glob($filepath . '.php');

        $view_folder_name = explode("/", $view_folder_name);
        $route = end($view_folder_name);

        if (strtolower($route) == strtolower(login_page()) AND Auth::auth() == true) { 
            $this->navigate_to('dashboard');
        }
        else {
            // End of Return data from backend to frontend  
            $current_file = current($files); 
            if (isset($current_file)) { 
                return $current_file;
            }  
        } 
    }

    public function set_alert_properties($message) {
        if (isset($message)){
            if (count($message) > 0) {
                $_SESSION['status'] = $this->status = isset($message['status']) 
                    ?   $message['status'] 
                    :   null;
                $_SESSION['message'] = $this->message = isset($message['message']) 
                    ?   $message['message'] 
                    :   null;
            } 
        }
    }

    public function navigate_to($route, $message = [])
    { 
        if (isset($route)) {
            $this->route = str_replace(".", "/", $route);   

            if (is_array($message) && count($message) > 0) {  
                $this->set_alert_properties($message);
                extract($_SESSION);
            } 
            
            header("Location: /" . $this->route);
            exit();
        }  
    }

    public function go_back($route = null, $message = [])
    { 
        if (isset($route)) {
            $this->route = ($route == null || is_array($route)) ? $_SERVER['HTTP_REFERER'] : (str_replace(".", "/", $route));

            if (is_array($message) && count($message) > 0) {
                $this->set_alert_properties($message);
            }
    
            header("Location: /" . $this->route);
            exit(); 
        }
    }
}
