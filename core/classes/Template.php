<?php

class Template
{
    /**
     * Define path to templates
     */
    const TEMPLATES_PATH = '../resources/views/';
    
    /**
     * Store variables which we path to template file
     */
    public static $data;

    /**
     * If variable $this->name is not found,
     * then take value from $this->data[$name]
     */
    public function __get($name) {
        if (isset($this->data[$name])) return $this->data[$name];
        return "";
    }
    
    /**
     * Process template file and return resulting content
     * 
     * @param string $template Template file name, can include path relative
     *    to templates directory
     * 
     * @return string Processed content of template
     */
    public static function view($template, $params = [])
    {
        ob_start();
        require(self::TEMPLATES_PATH.$template.'.html.php');
        return ob_get_clean();
    }
    
    public function set($name, $value) {
       // self::data[$name] = $value;
    }

}
