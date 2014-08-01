<?php

/**
 * Description of Controller
 *
 * @author imerin
 */

abstract class Controller
{
    protected $action_params;
    protected $post_params;

    protected $registry;
    protected $model;
    protected $view;

    
    public function __construct(array $action_params = array(), $registry = null,
            array $post_params = array(), Model $model = null, View $view = null)
    {
        $this->init($action_params, $registry, $post_params, $model, $view);
    }


    public function init($action_params, $registry, $post_params, $model, $view)
    {
        $this->setActionParams($action_params);
        $this->setRegistry($registry);
        $this->setPostParams($post_params);
        if (!is_null($model))
        {
            $this->setModel($model);
        }
        if (!is_null($view))
        {
            $this->setView($view);
        }
    }


    public function getActionParams()
    {
        return $this->action_params;
    }


    public function getPostParams()
    {
        return $this->post_params;
    }


    private function getView()
    {
        return $this->view;
    }


    private function getModel()
    {
        return $this->model;
    }


    public function setActionParams($params)
    {
        if (!is_array($params))
        {
            return false;
        }
        
        $this->action_params = $params;     //$this->params = $this->sanitizeParams($params);
    }


    public function setPostParams(array $params)
    {
        $this->post_params = $params;       //sanitize params
    }


    private function setView(View $view)
    {
        $class = new ReflectionClass('View');

        if (!$class->isInstance($view) && !is_null($view))
        {
            return false;
        }

        $this->view = $view;
    }


    private function setModel(Model $model)
    {
        $class = new ReflectionClass('Model');

        if (!$class->isInstance($model) && !is_null($model))
        {
            return false;
        }

        $this->model = $model;
    }


    private function setRegistry($registry)
    {
        $this->registry = $registry;
    }

}

?>