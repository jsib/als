<?php
/* 
 * index.php
 * This file is entry point to access the blog
*/

//Require main config file
require_once('../app/config.php');

//Require autoloader class
require_once(CORE_CLASSES_PATH."Autoload.php");

//Set autoloader
spl_autoload_register('Autoloader::init');

//Require functions without classes
require_once('../functions/errors.php');

//Set error handler
set_error_handler("error_handler");

//Implement connection to database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

//Get controller name and call this controller
$controller_name = Uri::parse()->getPath(1);

//Check for controller existence
if (!file_exists(CONTROLLERS_CLASSES_PATH.$controller_name.".php")) {
    error_log("Cannot find controller class file ".CONTROLLERS_CLASSES_PATH.$controller_name.".php");
    exit;
}

if (!class_exists($controller_name)) {
    error_log("Cannot find controller class with name ".$controller_name);
    exit;
}

//Call controller
require_once CONTROLLERS_CLASSES_PATH.$controller_name.".php";

//$controller = new controller();










