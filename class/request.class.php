<?php

/**
 * Description of request
 *
 * @author imerin
 */

class Request
{
    private $get;
    private $post;


    public function __construct(array $get = array(), array $post = array())
    {
        $this->setGet($get);
        $this->setPost($post);
    }


    public function  __toString()
    {
        return spl_object_hash($foo) .' : Request Object :
                    GET('. count($this->get) .') -
                    POST('. count($this->post) .')';
    }


    public function getGet()
    {
        return $this->get;
    }


    public function getPost()
    {
        return $this->post;
    }


    public function getGetParam($key)
    {
        if (!isset($this->get[$key]))
        {
            return null;
        }

        return $this->get[$key];
    }


    public function getPostParam($key)
    {
        if (!isset($this->post[$key]))
        {
            return false;
        }

        return $this->post[$key];
    }


    public function setGet(array $params)
    {
        if (empty($params))
        {
            $this->get = array();
        }

        foreach ($params as $key => $value)
        {
            $this->setGetParam($key, $value);
        }
    }


    public function setPost(array $params)
    {
        if (empty($params))
        {
            $this->post = array();
        }

        foreach ($params as $key => $value)
        {
            $this->setPostParam($key, $value);
        }
    }


    public function setGetParam($key, $value)
    {
        if (Sanitize::isInjectedString($key) || Sanitize::isInjectedString($value))
        {
            d::fp("parameter is injected with risky content GET[{$key}] = {$value}", 'ERROR(code)::', 'e');
            return false;
        }

        $this->get[strtolower($key)] = $value;
    }


    public function setPostParam($key, $value)
    {
        if (Sanitize::isInjectedString($key) || Sanitize::isInjectedString($value))
        {
            d::fp("parameter is injected with risky content POST[{$key}] = {$value}", 'ERROR(code)::', 'e');
            return false;
        }

        $this->post[strtolower($key)] = $value;
    }
    

    public function getControllerName()
    {
        return strtolower($this->getGetParam('controller'));
    }


    public function getActionName()
    {
        return strtolower($this->getGetParam('action'));
    }


    public function getActionParams()
    {
        $action_params = array();

        foreach ($this->get as $key => $value)
        {
            if ($key !== 'controller' && $key !== 'action')
            {
                $action_params[$key] = $value;
            }
        }

        return $action_params;
    }


    //@TODO : implement redirection, with some urls it makes a cyclic redirection
    // so failing. get app base path in config file (actual one is php_fw)
    static public function redirect($url)
    {
//d::fp(null,"Redirecting to $url");
//d::fp(dirname(dirname(__FILE__)), 'Ruta fichero actual');
        //$url = Config::getParamByPath('path/app').$url;
        header("Location: $url");
    }

}

?>