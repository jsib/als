<?php
/* 
 * Realize methods for working with URIs: parse, etc
 */
class Uri
{
    /**
     * URI transormed to array
     */
    public static $uri;
    
    /**
     * Keep instance of this class object, needed to make singleton 
     */
    private static $_instance = null;
    
    
    /**
     * Parse URI into array
    */
    public static function parse($uri_str = null)
    {
        //Define default value for uri string
        if ($uri_str === null) {
            $uri_str = $_SERVER['REQUEST_URI'];
        }
        
        //Perform first separation to two main parts
        $path_params = explode("?", $uri_str);
        
        $path_str = $path_params[0];
        
        if (count($path_params) > 1) {
            $params_str = $path_params[1];
        } else {
            $params_str = null;
        }
        
        //Now separate path to pieces        
        $path = explode("/", $path_str);
        
        //Remove zero empty piece
        unset($path[0]);
        
        //Remove last piece if it's empty
        if ($path[count($path)] == "") {
            unset($path[count($path)]);
        }
        
        //Reindex array
        $path = array_values($path);
        
        //Pass result
        self::$uri = ['path' => $path];
        
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;        
    }
    
    public static function getPath($key_number = null)
    {
        //Return full path array
        if ($key_number === null) {
            return self::$uri['path'];
        }
        
        //Return string with certain piece of path array
        return self::$uri['path'][$key_number];
    }
}