<?php

function route($controller, $callable_function)
{
    require controller_path($controller);

    $controller_class = new $controller();
    $controller_class->$callable_function();
}

function controller_path($controller)
{
    $controllerPath = $GLOBALS['controllerPath'];
    $modelsPath = $GLOBALS['modelsPath'];

    $controller_path = glob($controllerPath . DIRECTORY_SEPARATOR . $controller . '.php');

    return $controller_path[0];
}





