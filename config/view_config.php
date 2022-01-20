<?php 

class Page{ 
    public $RootDir;
    public $dotenv;

    public function __construct()
    {
        $this->RootDir = $GLOBALS['RootDir'];

        $this->dotenv = Dotenv\Dotenv::createImmutable('./');
        $this->dotenv->load(); 
    }

    public function View($view_folder_name, $view) { 
        $files = glob("." . DIRECTORY_SEPARATOR . $view_folder_name . DIRECTORY_SEPARATOR . $view . '.php');  

        require $files[0]; 
    } 
}



