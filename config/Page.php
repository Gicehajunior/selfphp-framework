<?php

require "./config/auth.php";
require "./config/Serve.php";

class Page{ 
    public $RootDir;
    public $dotenv; 

    public function __construct()
    {
        $this->RootDir = $GLOBALS['RootDir'];
    }

    public function View($view_folder_name, $view) { 
        $files = glob("." . DIRECTORY_SEPARATOR . $view_folder_name . DIRECTORY_SEPARATOR . $view . '.php');

        require "./config/config.php";
        require $files[0];
    } 

    public function navigate_to($path, $message=[]) { 
        $_SESSION['status'] = (array_keys($message)[0]) ? array_keys($message)[0] : null;
        $_SESSION['message'] = (array_values($message)[0]) ? array_values($message)[0] : null; 

        header("Location: " . $path);
        exit();
    }
}



