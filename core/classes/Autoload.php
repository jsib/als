<?php

/* 
 *Define autoloader for classes
 */
class Autoloader
{
    public static function init($class) 
    {
        require_once CORE_CLASSES_PATH.$class.".php";
    }
}

