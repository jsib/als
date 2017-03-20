<?php

namespace Core\Database;

/* 
 * Realize methods for working with MySQL database via mysqli extension
 */
class Database
{
    /**
     * Store MySQLi database server connection object
     */
    public $conn;
    
    /** Store MySQLi Result object
     * 
     */
    public $result;
    
    public function __construct()
    {
        $this->conn = new \mysqli(\DB_HOST, \DB_USER, \DB_PASSWORD, \DB_DATABASE);
    }

    /**
     * Return MySQLi database server connection object
     */
    public function conn()
    {
        return $this->conn;
    }
    
    /**
     * Execute SQL query to database
     */
    public function query($sql)
    {
        //Query database
        $this->result = $this->conn->query($sql);
        
        //Check for error
        if ($this->result === false) {
            \error("Database error: ". $this->conn->error);
        }
        
        return $this->result;
    }
    
    /**
     * Get row of result table
     */
    public function fetchRow()
    {
        return $this->result->fetch_row();
    }
    
    /**
     * Get array of objects which store information about database table fields
     */
    public function fetchFields()
    {
        return $this->result->fetch_fields();
    }
    
    /**
     * Get array with all rows of result table
     */
    public function fetchAll()
    {
        return call_user_func_array(array($this->result, 'fetch_all'), func_get_args());
    }
}

