<?php

/**
 * Description of auth
 *
 * @author imerin
 */

//@TODO: under construction
class Auth
{

    public function __construct()
    {

    }
    

    public function authenticate()
    {
        //@TODO: authenticate user and return the result of authentication
        //  return codes/messages: identity not found, password invalid, succes
        return $result;
    }


    public function storeSessionData()
    {
        //@TODO : store authenticated user data into session for further requests
        //  store a hash token in a client cookie and the session so they can be
        //  compared against each other
    }


    public function generateHash($string, $method = 'sha256')
    {
        if (!is_string($string) || $string === '')
        {
            d::fp("undefined or empty string ($string), cannot generate hash", 'ERROR(code)::', 'e');
            return false;
        }

        return hash(method, $string);
    }


    private function generateSalt($string = '')
    {
        $salt = $this->generateRandomString();

        if (is_string($string) && $string !== '')
        {
            $salt .= $string;
        }

        return $salt;
    }


    private function generateRandomString()
    {
        mt_srand(microtime(time)*10000 + memory_get_usage(true));
        return md5(uniqid(mt_rand(), true));
    }

}

?>