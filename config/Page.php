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

    public function __construct()
    {
        $this->RootDir = $GLOBALS['RootDir'];
    }

    public function View($view_folder_name, $view, $data = null)
    { 
        $files = glob("." . DIRECTORY_SEPARATOR . $view_folder_name . DIRECTORY_SEPARATOR . $view . '.php');

        if (is_array($data)) {
            if (count($data) > 0) {
                foreach ($data as $key => $value) { 
                    $$key = $value; 
                }
            }
        }

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

    public function navigate_to($path, $message = [])
    { 
        try {
            $this->set_alert_properties($message);
            
            header("Location: /" . $path);
            exit();
        } catch (\Throwable $th) {
            SP::debug_backtrace_show($th);
        }
    }

    public function go_back($path = null, $message = [])
    {
        try {
            $path = ($path == null || is_array($path)) ? $_SERVER['HTTP_REFERER'] : $path;

            $this->set_alert_properties($message);

            header("Location: /" . $path);
            exit();
        } catch (\Throwable $th) {
            SP::debug_backtrace_show($th);
        }
    }
}
