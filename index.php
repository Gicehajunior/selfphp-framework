<?php
$GLOBALS['RootDir'] = $_SERVER['DOCUMENT_ROOT'];

$GLOBALS['resource_views_dir'] = "resources";

$GLOBALS['controllerPath'] = [
    "./app/http/controllers",
    "./app/http/auth"
];

$GLOBALS['modelsPath'] = "./app";

require 'vendor/autoload.php';
require "routes/web.php";
