<?php

namespace Core\Facade;

abstract class Facade
{
    protected static $instances = [];
    
    protected static function getFacadeDescendant()
    {
        error('Facade descendant is not defined');
    }


    public static function __callStatic($method, $args)
    {
        $descendant = static::getFacadeDescendant();
        $descendant_with_namespace = '\\Core\\'.$descendant.'\\'.$descendant;

        if (
            isset(static::$instances[$descendant]) &&
            is_object(static::$instances[$descendant])
        ) {
            //do nothing
        } else {
            static::$instances[$descendant] = new $descendant_with_namespace;
        }
        
        return static::$instances[$descendant]->$method(...$args);
    }
}