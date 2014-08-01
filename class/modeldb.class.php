<?php

/**
 * Description of modeldb
 *
 * @author imerin
 */

abstract class ModelDb
{
    protected $db;


    public function __construct($driver, $type, $host, $port, $db_name, $user,
                                $pass, $encoding, $persistent)
    {
        $engine = new DbEngine($driver, $type, $host, $port, $db_name, $user,
                               $pass, $encoding, $persistent);
        
        $this->setDbEngine($engine);
    }


    public function getDbEngine()
    {
        return $this->db;
    }


    public function setDbEngine(DbEngine $engine)
    {
        $this->db = $engine;
    }

}

?>