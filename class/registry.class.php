<?php

/**
 * Description of register
 *
 * @author imerin
 */

class Registry
{
    private $config;
    private $request;
    private $session;
    private $app;

    private $global_vars = array();


    public function __construct()
    {

    }


    public function initConfig($conf)
    {
        $this->config = new Config();
        $this->config->setConf($conf);
    }


    public function initRequest($get, $post)
    {
        $this->request = new Request($get, $post);
    }


    public function initSession($session)
    {
        //$this->session = new Session($session);
        $this->session = Session::getInstance();
    }


    public function getConfigInstance()
    {
        return $this->config;
    }


    public function getConfig()
    {
        return $this->config->getConf();
    }


    public function setConfig($conf)
    {
        $this->config->setConf($conf);
    }

        //Config Wrappers
        public function getConfigSection($section_name)
        {
            return $this->config->getConfSection($section_name);
        }


        public function getConfigParamByKey($key)
        {
            return $this->config->getParamByKey($key);
        }


        public function getConfigParamByPath($path)
        {
            return $this->config->getParamByPath($path);
        }


        public function setConfigSection($section_name, $section_values)
        {
            $this->config->setConfSection($section_name, $section_values);
        }


    public function getRequest($get_or_post = 'GET')
    {
        if ($get_or_post === 'POST')
        {
            return $this->request->getPost();
        }
        else
        {
            return $this->request->getGet();
        }
    }


    public function setRequest($request)
    {
        $this->request = $request;
    }

        //Request wrappers
        public function getModelName()
        {
            return $this->getControllerName();
        }


        public function getViewName()
        {
            return $this->getControllerName();
        }


        public function getControllerName()
        {
            return $this->request->getControllerName();
        }


        public function getActionName()
        {
            return $this->request->getActionName();
        }


        public function getActionParams()
        {
            return $this->request->getActionParams();
        }


        public function getGet()
        {
            return $this->request->getGet();
        }


        public function getPost()
        {
            return $this->request->getPost();
        }


        public function getGetParam($key)
        {
            return $this->request->getGetParam($key);
        }


        public function getPostParam($key)
        {
            return $this->request->getPostParam($key);
        }

        //public function setGet($params)
        //public function setPost()

        public function setGetParam($key, $value)
        {
            $this->request->setGetParam($key, $value);
        }


        public function setPostParam($key, $value)
        {
            $this->request->setPostParam($key, $value);
        }


    public function getSession()
    {
        return $this->session;
    }


    public function setSession($session)
    {
        $this->session = $session;
    }
        
    
    public function __get($identifier)
    {
        if (!isset($this->global_vars[$identifier]))
        {
            d::fp("undefined global variable($identifier) in registry", 'ERROR(code)::', 'e');
            return false;
        }

        return $this->global_vars[$identifier];
    }

    
    public function __set($identifier, $value)
    {
        $this->global_vars[$identifier] = $value;
    }


    public function __isset($identifier)
    {
        return isset($this->global_vars[$identifier]);
    }


    public function __unset($identifier)
    {
        unset($this->global_vars[$identifier]);
    }

}

?>