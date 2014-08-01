<?php

/**
 * Description of Config
 *
 * @author imerin
 */

class Config
{
    private $conf = array();


    public function __construct()
    {

    }

    public function getConf()
    {
        return $this->conf;
    }


    public function getConfSection($section_name)
    {
        if (!isset($this->conf[$section_name]))
        {
            return false;
        }
        
        return $this->conf[$section_name];
    }


    public function setConf(array $conf)
    {
        $this->conf = $conf;
    }


    public function setConfSection($section_name, array $section_values)
    {
        $this->conf[$section_name];
    }


    public function getParamByKey($key)
    {
        if (!is_string($key) || $key === '')
        {
                return null;
        }

        return FzArray::searchMultiArrayByKey($key, $this->conf);
    }


    public function getParamByPath($path)
    {
        if (!is_string($path) || $path === '')
        {
            return null;
        }

        $array_path = explode('/', $path);

        return FzArray::searchMultiArrayByPath($array_path, $this->conf);
    }
 
}

?>