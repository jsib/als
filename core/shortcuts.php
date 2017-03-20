<?php

use Core\Facades\View;

/**
 * Shortcut for Debug::dump() method
 */
function dump()
{
    return call_user_func_array(array('Debug', 'dump'), func_get_args());
}

/**
 * Shortcut for Debug::error() method
 */
function error()
{
    return call_user_func_array(array('Debug', 'error'), func_get_args());
}

/**
 * Shortcut for Template::view() method
 */
function view()
{
    return call_user_func_array(array('View', 'load'), func_get_args());
}
