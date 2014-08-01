<?php

/**
 * Description of Application
 *
 * @author imerin
 */

class Application
{
    private $registry;

    private $model;
    private $view;
    private $controller;


    public function __construct(array $conf, array $get = array(), array $post = array())
    {
        //init configuration
        $this->initRegistry($conf, $get, $post);
        
        //init static classes        
        $this->initDebugger();
        $this->initSanitizer();

        //init dynamic classes
        $this->instantiateAppClasses();
        $this->initRequest($get, $post);
        $this->initEntities();
        
        //$this->initFzException();
    }


    private function instantiateAppClasses()
    {
        $classes = $this->registry->getConfigParamByPath('file/class/app');
        $instantiable_classes = $this->registry->getConfigParamByPath('class/instantiable');
d::gs('Instantiating Classes');
d::fp($instantiable_classes);
d::ge();

        foreach ($classes as $class_name => $file_name)
        {
            if (!class_exists($class_name))
            {
                d::fp("class has not been declared ($class_name)", 'ERROR(code)::', 'e');
                die();
            }

            if (in_array($class_name, $instantiable_classes))
            {
                $this->{strtolower($class_name)} = new $class_name();
            }
        }
    }


    private function initRegistry($conf, $get, $post)
    {
        $this->registry = new Registry();
        
        $this->registry->initConfig($conf);
        $this->registry->initRequest($get, $post);
        //$this->registry->initSession($session);
    }


    private function initDebugger()
    {
        d::setEnabled($this->registry->getConfigParamByPath('opt/debug/enabled'));
    }


    private function initSanitizer()
    {
        //nothing to do
    }


    private function initRequest($get, $post)
    {
        $this->registry->initRequest($get, $post);

        $this->checkController();
        $this->checkAction();
        
d::gs('Iniatializing Request');
d::fp($this->registry->getRequest());
d::ge();
    }


    private function initSession()
    {
        $this->registry->initSession();
    }


    private function initEntities()
    {
        $this->loadMVCFile($this->registry->getModelName(), 'model');
        $this->loadMVCFile($this->registry->getViewName(), 'view');
        $this->loadMVCFile($this->registry->getControllerName(), 'controller');

d::gs('Initialized Controller');
d::fp($this->controller);
d::ge();
    }


    private function checkController()
    {
        $defined_controllers = $this->registry->getConfigParamByPath('mvc/controller');
        $controller = $this->registry->getGetParam('controller');

        if (is_null($controller))
        {
            $controller = $defined_controllers['default'];
        }

        if (!in_array($controller, $defined_controllers))
        {
            d::fp("undefined controller ($controller)", 'ERROR(code)::', 'e');
            return false;                                           //@TODO : redirect to home page
        }

        $this->registry->setGetParam('controller', $controller);
    }


    private function checkAction()
    {
        $action = $this->registry->getGetParam('action');
        
        if (is_null($action) || $action === '')
        {
            $this->registry->setGetParam('action', 'index');
        }
    }

    
    private function loadMVCFile($file_name, $type = 'controller')
    {
        if (!in_array($type, array('controller', 'view', 'model')))
        {
            d::fp("undeclared MVC file type ($type)", 'ERROR(code)::', 'e');
            return false;
        }

        if ($type === 'view')
        {
            $file_name = $file_name
                        .ucfirst($this->registry->getActionName());
        }
        $path = $this->registry->getConfigParamByPath("path/$type")
               .$file_name
               .$this->registry->getConfigParamByPath("opt/$type/file_suffix");

        if (!file_exists($path))
        {
            d::fp("MVC($type) file does not exist ($path)", 'ERROR(code)::', 'e');
            return false;
        }

        if ($type !== 'view')
        {
            include_once $path;
        }

        $this->instantiateMVCEntity($file_name, $type);
    }


    private function instantiateMVCEntity($entity_name, $type)
    {
        $class_name = $entity_name.ucfirst($type);

        if (!class_exists($class_name) && $type !== 'view')
        {
            d::fp("undefined MVC class type ($class_name)", 'ERROR(code)::', 'e');
            return false;
        }

        switch ($type)
        {
            case 'controller':
                $this->controller = new $class_name(
                        $this->registry->getActionParams(),
                        $this->registry,
                        $this->registry->getPost(),
                        $this->model,
                        $this->layout);
                break;

            case 'model':
//$mi_var = $this->registry->getConfigInstance();
                $this->model = new $class_name($entity_name,
                                               $this->registry->getConfigInstance());
                $this->model->init();
                break;

            case 'view':                
                $template_file = $this->getTemplatePath($entity_name);
                $this->template = new Template($template_file);
                
                $layout_file = $this->getLayoutPath();
                $layout_params = $this->getLayoutParams();                
                $this->layout = new Layout($layout_file, $layout_params);
                $this->layout->setChildViews(array('content' => $this->template));
                break;

            default:                
                d::fp("undefined MVC entity type ($type)", 'ERROR(code)::', 'e');      //it is checked inside loadMVCFile show it is not needed
                break;
        }
    }


    private function getLayoutPath()
    {
        return $this->registry->getConfigParamByPath('path/layout')
              .$this->getLayoutName()
              .$this->registry->getConfigParamByPath('opt/view/file_suffix');
    }


    private function getLayoutName()
    {
        $params = $this->getLayoutParams();

        if (!isset($params['name']))
        {
            d::fp("undefined default layout name ($params[name])", 'ERROR(code)::', 'e');
            return false;
        }

        return $params['name'];
    }


    private function getLayoutParams()
    {
        $controller_actions = $this->registry->getConfigParamByPath(
                                'mvc/layout/'.$this->registry->getControllerName());

        if ($controller_actions)
        {
            if (in_array('all', array_keys($controller_actions)))
            {
                $action_name = 'all';
            }
            else
            {
                $action_name = $this->registry->getActionName();
            }

            $params = $this->registry->getConfigParamByPath(
                                 'mvc/layout/'.$this->registry->getControllerName().'/'
                                .$action_name);
        }
        else
        {
            $params = false;
        }
        
        if (!$params)
        {
            $params = $this->registry->getConfigParamByPath('mvc/layout/default');
        }

        return $params;
    }


    private function getTemplatePath($template_name)
    {
        return $this->registry->getConfigParamByPath('path/template')
              .$template_name
              .$this->registry->getConfigParamByPath('opt/view/file_suffix');
    }


    private function isActionCallable($action_name)
    {
        return is_callable(array($this->controller, $action_name));
    }


    public function callAction($action, $params)
    {
d::gs('Ejecutando Acción', false);
        $action_name =  
            $action.
            $this->registry->getConfigParamByPath('opt/controller/action_suffix');

        if (!$this->isActionCallable($action_name))
        {
            d::fp("action is not callable ($action_name)", 'ERROR(code)::', 'e');
            return false;
        }
d::fp($action_name, 'Acción');
d::fp($params, 'Parámetros');
d::ge();

        $this->controller->$action_name();
    }


    public function executeController()
    {
d::gs('Ejecutando Controlador', false);
        $this->callAction(  $this->registry->getGetParam('action'),
                            $this->registry->getActionParams('params'));
d::ge();
    }

    
    public function execute()
    {
d::gs('Ejecutando Aplicación', false);
        $this->executeController();
d::ge();
    }

}

?>