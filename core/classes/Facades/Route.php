<?php

namespace Core\Facades;

use Core\Facade\Facade;

class Route extends Facade
{
    protected static function getFacadeDescendant()
    {
        return 'Route';
    }
}


