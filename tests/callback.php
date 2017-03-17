<?php

function string($string, $callback)
{
    $results = [
        'upper' => strtoupper($string),
        'lower' => strtolower($string)
    ];
    
    if (is_callable($callback)) {
        call_user_func($callback, $results);
    }
}

string('Alex', function ($name) {
    echo $name['lower'];
});
