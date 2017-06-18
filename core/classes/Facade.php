<?php

namespace Core\Facade;

/**
 * Facade class realize provide convinient way to appeal object,
 * which don't need to create multiple instances during
 * application working time (e.g. Database, Template, Router, ...)
 * 
 * With facade machinery we call objects of necessary class
 * like as though it's static method, e.g.: Route::add(), DB::connect().
 * But in reality we create real object and work with it, and facade
 * machinery keep information for this object when we need to call it.
 * 
 * For each facade of certain object there is should be child inherited
 * class in 'Facades' folder, which realize single method getFacadeDescendant();
 */
abstract class Facade
{
    /**
     * Keep object instances, one per object
     */
    protected static $instances = [];
    
    /**
     * Facade descendant provide tunnel for calling facade
     * by actually needed class name. This method should be replaced
     * with child method of certain descendant.
     */
    protected static function getFacadeDescendant()
    {
        error('Facade descendant is not defined');
    }

    /**
     * Realize substitutution. It means, when we call some object method,
     * e.g. DB::connect(), facade in fact use __callStatic to call 
     * method of target class.
     * 
     */
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
