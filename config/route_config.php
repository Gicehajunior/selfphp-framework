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

    $controller_found_array = array();

    foreach ($controllerPath as $controller_folder) { 
        $controller_path = glob($controller_folder . DIRECTORY_SEPARATOR . $controller . '.php');

        array_push($controller_found_array, $controller_path);
    } 

    return $controller_found_array[0][0] ? $controller_found_array[0][0] : $controller_found_array[1][0];
}




