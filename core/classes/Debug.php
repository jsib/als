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
     * Process error
     */
    public static function error($text, $type = E_ERROR)
    {
        //Show error text and debug_backtrace information
        self::show($text);
        
        if ($type == E_ERROR) {
            exit;
        }
    }

    /**
     * Print text of the error and debug backtrace information
     * 
     * @param string $error     Full and prepared info of the error in HTML format
     */
    public static function show($error)
    {
            //Add debugging info to the end of message
            $error .= PHP_EOL . @print_r(debug_backtrace(), true);

            //Form final HTML
            echo '<div style="margin: 20px 0; border:1px solid #000; padding:10px; background:#AAA; font-family:Tahoma; z-index:1000;">';
            echo '<h1 style="font-family:Tahoma; font-size:12pt; font-weight:normal; color:red;">Ошибка</h1>';
            echo '<pre>' . $error . '</pre>';
            echo '</div>';
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
        $error = 'Debug::handleError' . PHP_EOL;

        if (!(error_reporting() & $errno)) {
            $error .= 'This error code not set in  error_reporting, that\'s why it also handles by standart PHP error handling mechanism.' . PHP_EOL;
        }

        //Form info about error
        $error .= 'Error code:' . $errno . PHP_EOL;
        $error .= 'Error description:' . PHP_EOL . $errstr . PHP_EOL;
        $error .= 'Debugging info:' . PHP_EOL;

        //Show information about error to screen
        self::error($error);

        //Don't start standart PHP handling mechanism
        return true;
    }
}