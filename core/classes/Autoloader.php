<?php

/* 
 * This class responsible for autoload necessary classes
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
        $parts = explode('\\', $class);

        if (isset($parts[1]) && $parts[1] == 'Facades' && isset($parts[2])) {
            require CORE_CLASSES_PATH . $parts[1] . '/' . $parts[2] . '.php';
        } else {
            require end($parts) . '.php';
        }
    }
}

