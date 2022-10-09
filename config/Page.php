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
 
        // return session variable values for the user
        $auth = (isset($_SESSION)) ? $_SESSION : null;

        // Return data from backend to frontend
        if (isset($_SESSION['status']) || isset($_SESSION['message'])) {   
            $status = $_SESSION['status']; 
            $message = $_SESSION['message'];
        }  

        if (Auth::auth() == true) { 
            $Auth = true;
        } 
        else {
            $Auth = false;
        }

        if (is_array($data)) {
            if (count($data) > 0) {
                foreach ($data as $key => $value) { 
                    $$key = $value; 
                }
            }
        }

        // End of Return data from backend to frontend 
        require $files[0];
        
        unset($_SESSION['status']);
        unset($_SESSION['message']);
    }


    public function navigate_to($path, $message = [])
    {
        if (count($message) > 0) {
            $_SESSION['status'] = $this->status = (array_keys($message)[0]) 
                ? array_keys($message)[0] 
                : null;
            $_SESSION['message'] = $this->message = (array_values($message)[0]) 
                ? array_values($message)[0] 
                : null;
        }
        
        header("Location: " . $path);
        exit();
    }

    public function go_back($path = null, $message = [])
    {
        $path = ($path == null || is_array($path)) ? $_SERVER['HTTP_REFERER'] : $path;

        if (count($message) > 0) {
            $_SESSION['status'] = $this->status = (array_keys($message)[0]) 
                ? array_keys($message)[0] 
                : null;
            $_SESSION['message'] = $this->message = (array_values($message)[0]) 
                ? array_values($message)[0] 
                : null;
        }

        header("Location: " . $path);
        exit();
    }
}
