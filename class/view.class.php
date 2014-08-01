<?php

/**
 * Description of View
 *
 * @author imerin
 */

abstract class View 
{
    private $path;
    private $params;
    private $html;
    private $child_views = array();


    public function __construct($path = '', array $params = array(), array $child_views = array())
    {
        $this->init($path, $params, $child_views);
    }


    public function init($path, array $params = array(), array $child_views = array())
    {
        $this->setHtml('');
        $this->setPath($path);
        $this->setParams($params);
        if ($child_views)
        {
            $this->setChildViews($child_views);
        }
    }


    protected function getPath()
    {
        return $this->path;
    }


    protected function getParams()
    {
        return $this->params;
    }


    protected function getHtml()
    {
        return $this->html;
    }

    public function getChildViews()
    {
        return $this->child_views;
    }


    protected function setPath($path)
    {
        if (!is_string($path))
        {
            return false;
        }

        $this->path = $path;
    }


    public function setParams(array $params)
    {
        $this->params = $params;
    }


    protected function setParam($name, $value)
    {
        if (!is_string($name) || is_null($value))
        {
            return false;
        }

        $this->params[$name] = $value;
    }


    protected function setHtml($html)
    {
        if (is_null($html))
        {
          return false;
        }

        $this->html = $html;
    }


    public function setChildViews(array $views)
    {
        foreach ($views as $key => $value)
        {
            $this->setChildView($key, $value);
        }
    }


    protected function setChildView($name, $value)
    {
        //$class = new ReflectionClass('View');
        $class = new ReflectionClass('Template');

        if (!is_string($name) || !$class->isInstance($value))
        {
            return false;
        }

        $this->child_views[$name] = $value;
    }


    protected function setChildViewParams($name, array $params)
    {
        if (!isset($this->child_views[$name]))
        {
            return false;
        }

        $this->child_views[$name]->setParams($params);
    }


            //debug
            public function showHtml()
            {
                pre(htmlentities($this->html), 'Views::showHtml -> Mostrando contenido html:');
            }


            //debug
            public function showChildViews()
            {
                echo '<b>Views::showChildViews -> Mostrando plantillas hijas:</b> <br/>';
                foreach ($this->child_views as $key => $value)
                {
                    echo "Nombre: $key<br/>";
                    pre($value);
                }
            }


    protected function parseChildViews()
    {
        $parsed_views = array();
        $child_views = $this->getChildViews();

        foreach ($child_views as $key => $view)
        {
            $parsed_views[$key] = $view->render();
        }

        return $parsed_views;
    }


    abstract protected function parse();


    public function render($child_view_name = null, array $child_view_params = null)
    {
        if ($child_view_name && $child_view_params)
        {
            $this->setChildViewParams($child_view_name, $child_view_params);
        }

        $this->parse();

        return $this->html;
    }

}

?>