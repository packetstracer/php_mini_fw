<?php

/**
 * Description of fzexception
 *
 * @author imerin
 */

class FzException extends Exception
{

    //inherited Exception methods
    //final public  function getMessage();        // message of exception
    //final public  function getCode();           // code of exception
    //final public  function getFile();           // source filename
    //final public  function getLine();           // source line
    //final public  function getTrace();          // an array of the backtrace()
    //final public  function getPrevious();       // previous exception
    //final public  function getTraceAsString();  // formatted string of trace


    public function __construct($message, $code = 0, Exception $previous = null, $log_level = 0)
    {
        parent::__construct($message, $code, $previous);
        $this->log($log_level);
    }


    public function  __toString()
    {
        return parent::__toString();
        //return __CLASS__ ." [$this->code]: $this->message\n";
    }


    public function log($log_level = 1)
    {
        if ($log_level === 1)           // 0 = none | 1 = normal | 2 = verbose
        {
            //log to log file ($conf['file']['log']['error'])
        }
        else if ($log_level === 2)
        {
            //log to file verbose
        }
    }

}

?>
