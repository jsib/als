<?php

$callback = function ($name) {
    echo $name['lower'];
};

function string($string)
{
    global $callback;
    
    $results = [
        'upper' => strtoupper($string),
        'lower' => strtolower($string)
    ];
    
    if (is_callable($callback)) {
        call_user_func($callback, $results);
    }
}

string('Nick');
