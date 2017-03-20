<?php

namespace Core\Debug;

/* 
 * Provide methods for debugging and error reporting
 */
class Debug
{
    /**
     * Store debug_backtrace() prepared array
     */
    private static $debug = [];
    
    /*
     * Store error number
     */
    private static $errno;
    
    /**
     * Store error file
     */
    private static $errfile;
    
    /**
     * Store error line number
     */
    private static $errline;
    
    /**
     * Means, that this error code not set in  error_reporting
     */
    private static $errno_uknown = false;    
    
    /**
     * Show detailed information about given variable
     * 
     * @param $input   Any kind of variable
     */
    public static function dump($input, $label = '')
    {
        if ($label !== '') {
            echo '<h1>'.$label.":</h1><br/>";
        }
        
        //Special condition for boolean values
        if (is_bool($input)) {
            switch ($input) {
                case true:
                    $input = 'true';
                    break;
                case false:
                    $input = 'false';
                    break;
            }
        }
        
        //Show info
        echo "<pre>";
        print_r($input);
        echo "</pre>";
    }
    
    /**
     * Show error message and stop script
     */
    public static function error(
        $error,
        $errno = false,
        $errfile = false,
        $errline = false,
        $errno_uknown = false
    ){
        //Start showing debug_backtrace() information
        $debug = debug_backtrace();
        
        //Remove Debug::error() entry
        $debug = self::removeEntry($debug, 0, __CLASS__, 'error');

        //Remove Debug::error() entry
        $debug = self::removeEntry($debug, 1, __CLASS__, 'handleErrors');

        //Reindex array
        self::$debug = array_values($debug);

        //Start catching output
        ob_start();

        //Execute template
        require(
            \Core\View\View::TEMPLATES_PATH.
            'debug_backtrace/debug_backtrace'
            .'.html.php'
        );

        //Echo catched output
        echo ob_get_clean();

        //Stop script execution
        exit;
    }

    /**
     * Handling appeared errors
     * 
     * @param type $errno
     * @param type $errstr
     * @param type $errfile
     * @param type $errline
     * @return boolean
     */
    public static function handleErrors($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            //Means, that this error code is not set in  error_reporting,
            //i.e. this error code should be handled by standart PHP
            //error handling mechanism.
            $errno_uknown = true;
        } else {
            $errno_uknown = false;
        }
        
        //Show error information and stop script
        self::error($errstr, $errno, $errfile, $errline, $errno_uknown);

        //Don't start standart PHP handling mechanism
        return true;
    }
    
    /**
     * Remove entry from debug information array
     * 
     * @param $debug Array Debug input array
     * @param $class string Name of entry class
     * @param $function string Name of entry function
     * @return Array Debug input array with deleted entries
     */
    private static function removeEntry($debug, $key, $class, $function)
    {
        //Take appropriate entry from debug array
        $entry = $debug[$key];
        
        //Check entry properties
        if ($entry['class'] == $class && $entry['function'] == $function) {
            unset($debug[$key]);
        }
        
        return $debug;
    }
}