<?php

namespace Core\Facades;

use Core\Facade\Facade;

class DB extends Facade
{
    protected static function test()
    {
        echo("i m test");
    }
    
    protected static function getFacadeDescendant()
    {
        return 'Database';
    }
}


