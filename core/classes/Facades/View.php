<?php

namespace Core\Facades;

use Core\Facade\Facade;

class View extends Facade
{
    protected static function getFacadeDescendant()
    {
        return 'View';
    }
}


