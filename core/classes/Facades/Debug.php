<?php

namespace Core\Facades;

use Core\Facade\Facade;

class Debug extends Facade
{
    protected static function getFacadeDescendant()
    {
        return 'Debug';
    }
}


