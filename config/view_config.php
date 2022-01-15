<?php

class Page{ 
    public $RootDir;

    public function __construct()
    {
        $this->RootDir = $GLOBALS['RootDir'];
    }

    public function View($view_folder_name, $view) { 
        $files = glob("." . DIRECTORY_SEPARATOR . $view_folder_name . DIRECTORY_SEPARATOR . $view . '.php'); 
        require $this->return_asset(".env-loader");

        require $files[0]; 
    }

    public static function return_asset($asset)
    {
        return $asset . '.php';
    }
}



