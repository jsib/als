<?php

use Core\Facades\Uri;
use Core\Facades\DB;
use Core\Facades\Route;
use Core\Facades\Auth;

//Include main config file
require_once('../app/config.php');

//Require autoloader class
require_once(CORE_CLASSES_PATH."Autoloader.php");

//Set classes autoloader
spl_autoload_register('Autoloader::init');

//Include routes, must be after autoloader
require_once('../app/routes.php');

//Include auth rules including anonymous routes, etc
require_once('../app/auth.php');

//Include some shortcuts for classes methods
require_once('../core/shortcuts.php');

//Set error handler
set_error_handler(array('Debug', 'handleErrors'));

//Create instance of Route class object and
//build route array with data from routes.php
Route::build();

//Start test if any presented
Route::startTest();

//Start cookie session and define is user authenticated
Auth::init();

//Start controller action, return HTML flow as a result
echo Route::startController();
