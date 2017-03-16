<?php
/* 
 * index.php
 * This file is entry point to access the blog
*/

//Include main config file
require_once('../app/config.php');

//Require autoloader class
require_once(CORE_CLASSES_PATH."Autoloader.php");

//Set autoloader
spl_autoload_register('Autoloader::init');

//Include routes, must be after autoloader
require_once('../app/routes.php');

//Set error handler
set_error_handler("Debug::handleErrors");

//Build route array with data from routes.php
Route::go()->build();

//Start test
if (Uri::parse()->getPath(0) === 'test') {
    require_once '../tests/'.Uri::parse()->getPath(1).'/'.Uri::parse()->getPath(2).'.php';
}

//Debug::dump(Route::build()->findByClientUri(), 'Route::buildArray->findByClientUri()');

//Implement connection to database
//$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

//Get controller name and call this controller
//$controller_name = mb_convert_case(Uri::parse()->getControllerName(),
//                                   MB_CASE_TITLE,
//                                   FILES_ENCODING
//                                  )."Controller";
//
////Check for controller existence
//if (!file_exists(CONTROLLERS_CLASSES_PATH.$controller_name.".php")) {
//    Debug::error("Cannot find controller class file ".CONTROLLERS_CLASSES_PATH.$controller_name.".php");
//}
//
////Attack controller's file
//require_once CONTROLLERS_CLASSES_PATH.$controller_name.".php";
//
//if (!class_exists($controller_name)) {
//    Debug::error("Cannot find controller class with name ".$controller_name);
//}

