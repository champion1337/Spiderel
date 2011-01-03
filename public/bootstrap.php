<?php

function callHook() {
    global $url;
    //define za install.lock file
    $install_lock = ROOT . DS . "install.lock";

    //check the route
    $urlArray = array();
    $urlArray = explode("/",$url);
    $controller = $urlArray[0];
    if (empty($controller)) {
        $controller = "spiderel";
    }
    array_shift($urlArray);
    if(empty($urlArray)) { //if no action is defined, use the index action
        $action = "index"; 
    }
    else {
        $action = $urlArray[0];
    }
    if (file_exists($install_lock)) {
        $controller = "install"; //load the install controller instead
    }
    array_shift($urlArray);
    $queryString = $urlArray;

    //include the controller
    $controllerName = $controller;
    $controller = ucwords($controller);
    $controller .= 'Controller';
    $controller_file = ROOT . DS . "controllers" . DS . $controller . ".php";
    if(file_exists($controller_file)) { 
        require_once($controller_file);
    }
    else {
        //404 error
        die("No such action"); 
    }
    //call the controller
    $model = "";
    
    $dispatch = new $controller($model,$controllerName,$action);
    if ((int)method_exists($controller, $action)) {
        call_user_func_array(array($dispatch,$action),$queryString);
    } else {
        die("Error processing the request"); //unknown error
    }
}

function __autoload($class) { //automatically load classes instead of using lots of includes
    $file1 = "classes". DS .  $class . "Class.php";
    if(file_exists($file1)) {
        include($file1);
    }
    else {
        die("Failed to include " . $class);
    }
}
callHook();
