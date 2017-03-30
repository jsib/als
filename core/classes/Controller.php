<?php

class Controller
{
    function __construct()
    {
        
    }
    
    /**
     * Send answer
     */
    protected function sendJsonAnswer($type, $text = '')
    {
        return json_encode([
            'type' => $type,
            'text' => $text
        ]);
    }

    /**
     * Send custom array
     */
    protected function sendJson($array)
    {
        return json_encode($array);
    }
    
}