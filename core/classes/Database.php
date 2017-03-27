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
    private $conn;
    
    /** 
     * Store mysqli result object
     */
    private $result;
    
    /**
     * Store mysqli statement object
     */
    public $stmt;
    
    /**
     * Prepared for execution binded params
     */
    private $bindedParams = [];
    
    
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
     * Get array of objects which store information about database table fields
     */
    public function fetchFields(...$args)
    {
        return $this->result->fetch_fields(...$args);
    }
    
    /**
     * Get array with all rows of result table
     */
    public function fetchAll($res_type = MYSQLI_ASSOC)
    {
        return $this->result->fetch_all($res_type);
    }
    
    /**
     * Fetch a row from result
     */
    public function fetch($res_type = MYSQLI_ASSOC)
    {
        //dump($this->result->num_rows);
        return $this->result->fetch_array($res_type);
    }
    
    /**
     * Return rows number of executed statement
     */
    public function numRows()
    {
        return $this->result->num_rows;
    }
    
    /**
     * Get id of last insert operation
     */
    public function insertId()
    {
        return $this->stmt->insert_id;
    }
    
    /**
     * Prepare SQL statement for execution
     */
    public function prepare($sql)
    {
        //Let's prepare existing statement
        $this->stmt = $this->conn->prepare($sql);
        
        //Handle errors
        if ($this->stmt === false) {
            \error("Error in SQL-statement: ".$sql);
            return false;
        }
        
        return $this;
    }
    
    /**
     * Bind param to prepared SQL statement
     */
    public function bindParam($param, $value)
    {
        //Add new binded parameter
        $this->bindedParams[$param] = $value;
        
        return $this;
    }
    
    /**
     * Execute prepared SQL statement
     */
    public function exec()
    {
        //If we have some parameters for binding in SQL statement
        if (count($this->bindedParams) > 0) {
            $bind_result = $this->stmt->bind_param(
                implode(array_keys($this->bindedParams)),
                ...array_values($this->bindedParams)
            );
        }
        
        //In case of error
        if ($bind_result === false) {
            \error(
                "Cannot bind param to stmt object. Params array:".NS_D.
                "Stmt error number: ".$this->stmt->errno.NS_D.
                "Stmt error text: ".$this->stmt->error
            );
            
        }
        
        //Execute SQL statement
        $result = $this->stmt->execute();
        
        //Store result for correct value of $num_rows, etc
        //$this->stmt->store_result();
        
        //In error case
        if ($result === false) {
            \error(
                "Cannot execute stmt object. ".NS_D.
                "Stmt error number: ".$this->stmt->errno.NS_D.
                "Stmt error text: ".$this->stmt->error
            );
        }
        
        //Prepare binded parameters for new statement
        $this->bindedParams = [];
        
        return $this;
    }
    
    /**
     * Get result of statement execution
     * 
     * @return void
     */
    public function getResult()
    {
        //Get mysqli result object
        $this->result = $this->stmt->get_result();
        
        //Handle errors
        if ($this->stmt->errno !== 0) {
            error(
                "Cannot get result of stmt object".NS_D.
                "Stmt error number: ".$this->stmt->errno.NS_D.
                "Stmt error text: ".$this->stmt->error
            );
        }
        
        return $this;
    }
}
