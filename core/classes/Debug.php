<?php

/* 
 * Provide methods for debugging and error reporting
 */
class Debug
{
    /**
     * Show detailed information about given variable
     * 
     * @param $input   Any kind of variable
     */
    public static function dump($input)
    {
        echo "<pre>";
        print_r($input);
        echo "</pre>";
    }
}