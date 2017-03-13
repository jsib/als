<?php
/* 
 * This file is responsible for handling appearing errors
 */

/**
 * Print text of the error and debug backtrace information
 * 
 * @param string $error     Full and prepared info of the error in HTML format
 */
function print_error($error){
	//Add debugging info to the end of message
	$error .= PHP_EOL . @print_r( debug_backtrace(), true );
	
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
function error_handler($errno, $errstr, $errfile, $errline){
    $error = 'Error source: Myblog Error Handler' . PHP_EOL;

    if ( !(error_reporting() & $errno) ) {
            if( ERR_SHOW_NO_REPORTED == false ){
                    return false;
            }else{
                    $error .= 'This error code not set in  error_reporting, that\'s why it also handles by standart PHP error handling mechanism.' . PHP_EOL;
            }
    }

    //Form info about error
    $error .= 'Error code:' . $errno . PHP_EOL;
    $error .= 'Error description:' . PHP_EOL . $errstr . PHP_EOL;
    $error .= 'Debugging info:' . PHP_EOL;

    //Show information about error to screen
    print_error($error);
	
    //Don't start standart PHP handling mechanism
    return true;
}
