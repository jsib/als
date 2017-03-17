<?php

use Core\Facades\Uri;
use Core\Facades\DB;
use Core\Facades\Route;

//Include main config file
require_once('../app/config.php');

//Require autoloader class
require_once(CORE_CLASSES_PATH."Autoloader.php");

//require_once('../core/classes/Facade.php');
//
//Set autoloader
spl_autoload_register('Autoloader::init');

//require_once('../core/classes/Database/DB.php');

//Include routes, must be after autoloader
require_once('../app/routes.php');

//Include some shortcuts for classes methods
require_once('../core/shortcuts.php');

//Set error handler
set_error_handler("Debug::handleErrors");

//Build route array with data from routes.php
Route::build();

//Start test
if (Uri::parse()->getPath(0) === 'tests' &&
    Uri::parse()->getPath(1) &&
    Uri::parse()->getPath(2)
) {
    require_once '../tests/'.Uri::parse()->getPath(1).'/'.Uri::parse()->getPath(2).'.php';
    exit;
}

if (Uri::parse()->getPath(0) === 'tests' &&
    Uri::parse()->getPath(1) &&
    !Uri::parse()->getPath(2)
) {

    require_once '../tests/'.Uri::parse()->getPath(1).'.php';
    exit;
}

//Implement connection to database
//$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

//Get controller name and call this controller
$route_array = Route::findRouteByClientUri();

if ($route_array === false) {
    //Error 404
    echo "<h1>Error 404, page not found.</h1>";
} else {
    $route = reset($route_array);
    $route_str = key($route_array);
}

$controller_name = $route['controller'].'Controller';
$action_name = $route['action'].'Action';

//Check for controller file existence
if (!file_exists(CONTROLLERS_CLASSES_PATH.$controller_name.".php")) {
    error("Cannot find controller class file ".CONTROLLERS_CLASSES_PATH.$controller_name.".php");
}
//
//Attach controller file
require_once CONTROLLERS_CLASSES_PATH.$controller_name.".php";

//
if (!class_exists($controller_name)) {
    error("Controller class with name ".$controller_name." doesn't exist.");
}

//Execute controller
$controller = new $controller_name;

if (!method_exists($controller, $action_name)) {
    error(
        "Method ".
        $action_name.
        " of controller class ".
        $controller_name.
        " doesn't exist."
    );
}

//Run controller
call_user_func(array($controller, $action_name));