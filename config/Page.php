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

    public function View($view_folder_name, $view, $data = null)
    { 
        $files = glob("." . DIRECTORY_SEPARATOR . $view_folder_name . DIRECTORY_SEPARATOR . $view . '.php');

        if (strtolower($view) == strtolower(login_page()) AND Auth::auth() == true) { 
            $this->navigate_to('dashboard', [
                'status' => 'info', 
                'message' => Auth('username') . ', Welcome back!'
            ]);
        }
        else {
            // End of Return data from backend to frontend 
            if (isset($files[0])) {
                return $files[0];
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
        try {
            if (isset($route)) {
                $this->route = $route;  
            } 

            if (is_array($message) && count($message) > 0) {  
                $this->set_alert_properties($message);
                extract($_SESSION);
            } 
            
            header("Location: /" . $route);
            exit();
        } catch (\Throwable $th) {
            SP::debug_backtrace_show($th);
        }
    }

    public function go_back($route = null, $message = [])
    {
        try {
            $this->route = ($route == null || is_array($route)) ? $_SERVER['HTTP_REFERER'] : $route;

            if (is_array($message) && count($message) > 0) {
                $this->set_alert_properties($message);
            }

            header("Location: /" . $this->route);
            exit();
        } catch (\Throwable $th) {
            SP::debug_backtrace_show($th);
        }
    }
}
