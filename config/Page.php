<?php

class Page
{
    public $RootDir;
    public $dotenv;
    public $status;
    public $message;

    public function __construct()
    {
        $this->RootDir = $GLOBALS['RootDir'];
    }

    public function View($view_folder_name, $view)
    {
        $files = glob("." . DIRECTORY_SEPARATOR . $view_folder_name . DIRECTORY_SEPARATOR . $view . '.php');

        require "./config/config.php";
        require $files[0];
    }


    public function navigate_to($path, $message = [])
    {
        $_SESSION['status'] = $this->status = (array_keys($message)[0]) ? array_keys($message)[0] : null;
        $_SESSION['message'] = $this->message = (array_values($message)[0]) ? array_values($message)[0] : null;

        header("Location: " . $path);
        exit();
    }

    public function go_back($path = null, $message = [])
    {
        $path = ($path == null || is_array($path)) ? $_SERVER['HTTP_REFERER'] : $path;

        $_SESSION['status'] = $this->status = (array_keys($message)[0]) ? array_keys($message)[0] : null;
        $_SESSION['message'] = $this->message = (array_values($message)[0]) ? array_values($message)[0] : null;

        header("Location: " . $path);
        exit();
    }

    public function AuthorizationMiddleware()
    {
        if (strtolower($_ENV['AUTH']) == 'true') {
            if (Auth::session_exists() == false) {
                $this->navigate_to(strtolower($_ENV['LOGOUT_DESTINATION']), ["error" => "Login is required!"]);
            }
        }
    }
}
