<?php

/**
 * Description of session
 *
 * @author imerin
 */

//@TODO: test class
class Session
{
    static private $instance;


    public function __construct()
    {
        session_start();
    }


    static public function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
    

    public function __get($identifier)
    {
        if (!isset($_SESSION[$identifier]))
        {
            d::fp("cannot set undefined session variable($identifier)", 'ERROR(code)::', 'e');
            return false;
        }

        return $_SESSION[$identifier];
    }


    public function __set($identifier, $value)
    {
        $_SESSION[$identifier] = $value;
    }


    public function __isset($identifier)
    {
        return isset($_SESSION[$identifier]);
    }


    public function __unset($identifier)
    {
        if (!isset($_SESSION[$identifier]))
        {
            d::fp("cannot unset undefined session variable($identifier)", 'ERROR(code)::', 'e');
            return false;
        }

        unset($_SESSION[$identifier]);
    }


    /* @TODO : a function that counts user clicks per visit
    public function countHits()
    {
        if (!isset($this->count))
        {
            $this->count = 0;
        }
        else
        {
            $this->count++;
        }

    }*/


    public function getFlashData()
    {
        return $this->flash_data;
    }


    public function setFlashData(array $data)
    {
        $this->flash_data = $data;
    }


    public function unsetFlashData()
    {
        unset($this->flash_data);
    }


    // public function regenerateId() { return regenerate_session_id(); } --> do we need to regenerate session id's


    public function getSessionId()
    {
        return session_id();
    }


    public function getSessionName()
    {
        return session_name();
    }


    public function destroy()
    {
        return session_destroy();
    }


    public function __destruct()
    {
        session_write_close();
    }

}

?>