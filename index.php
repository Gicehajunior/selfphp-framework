<?php
$GLOBALS['RootDir'] = $_SERVER['DOCUMENT_ROOT'];

$GLOBALS['resource_views_dir'] = "resources";

$GLOBALS['controllerPath'] = [
    "./app/http/controllers",
    "./app/http/auth"
];

$GLOBALS['modelsPath'] = "./app";

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

require "routes/web.php";


