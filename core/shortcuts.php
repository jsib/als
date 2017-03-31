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
function error(...$args)
{
    return Debug::error(...$args);
}

/**
 * Shortcut for Debug::ajaxError() method
 */
function ajax_error(...$args)
{
    return Debug::ajaxError(...$args);
}


/**
 * Shortcut for Template::view() method
 */
function view()
{
    return call_user_func_array(array('\Core\Facades\View', 'load'), func_get_args());
}
