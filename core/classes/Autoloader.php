<?php

/* 
 *This class responsible for autoload necessary classes
 */
class Autoloader
{
    /**
     * Autoload necessary classes
     * 
     * @param type $class
     * @return boolean
     */
    public static function init($class) 
    {
        //Iterate over pathes to classes
        foreach (AUTOLOAD_CLASSES_PATHES as $path) {
            //Get full path with file name to class
            $file = $path . $class . ".php";
                    
            //Include file with $class name only from one path
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }
    }
}

