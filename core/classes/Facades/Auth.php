<?php

namespace Core\Facades;

use Core\Facade\Facade;

class Auth extends Facade
{
    protected static function getFacadeDescendant()
    {
        return 'Auth';
    }
}


