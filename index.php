<?php
require __DIR__ . '/vendor/autoload.php';

$GLOBALS['RootDir'] = $_SERVER['DOCUMENT_ROOT'];

$GLOBALS['resource_views_dir'] = "resources";

$GLOBALS['controllerPath'] = [
    "./app/http/controllers",
    "./app/http/auth"
];

$GLOBALS['modelsPath'] = "./app";

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

require __DIR__ . "/routes/web.php";


