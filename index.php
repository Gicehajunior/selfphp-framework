<?php
require __DIR__ . '/vendor/autoload.php';

$GLOBALS['RootDir'] = $_SERVER['DOCUMENT_ROOT'];

$GLOBALS['resource_views_dir'] = "resources";

$GLOBALS['controllerPath'] = [
    "./app/http/controllers",
    "./app/http/auth"
];

$GLOBALS['modelsPath'] = "./app"; 

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { 
    if (!is_dir(__DIR__ . "/public/bootstrap/css") || !is_dir(__DIR__ . "/public/bootstrap/js")) {
        
        mkdir(__DIR__ . "/public/bootstrap/css");
        mkdir(__DIR__ . "/public/bootstrap/js");

        if (is_dir(__DIR__ . "/vendor/twbs/bootstrap/dist/") || is_dir(__DIR__ . "/vendor/twbs/bootstrap/dist/")) {
            $assets = [glob(__DIR__ . "/vendor/twbs/bootstrap/dist/css/*.css"), glob(__DIR__ . "/vendor/twbs/bootstrap/dist/js/*.js")];

            foreach($assets[0] as $assetKey => $assetValue) {  
                $assetValueBasename = basename($assetValue);
                copy($assetValue, __DIR__ . "/public/bootstrap/css/" . $assetValueBasename); 
            }

            foreach($assets[1] as $assetKey => $assetValue) {
                $assetValueBasename = basename($assetValue);
                copy($assetValue, __DIR__ . "/public/bootstrap/js/" . $assetValueBasename); 
            } 
        }
        
        if (!is_dir(__DIR__ . "/public/bootstrap/css/") || !is_dir(__DIR__ . "/public/bootstrap/js/")) {
            echo "<span>No Bootstrap Css and Js files set on public!</span>";
            exit();
        }
    }  
}

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

require __DIR__ . "/routes/web.php";


