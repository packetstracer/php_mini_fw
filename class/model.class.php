<?php

/**
 * Description of Model
 *
 * @author imerin
 */

abstract class Model
{
    private $name;
    protected $db_model;
    protected $config;
    

    public function __construct($name = '', Config $config = null)
    {
        $this->setName($name);
        $this->setConfig($config);
    }


    public function init()
    {
        $this->instantiateDbModel();
    }


    public function getName()
    {
        return $this->name;
    }


    public function getDbModel()
    {
        return $this->db_model;
    }


    public function setName($name)
    {
        if (!is_string($name))
        {
           return false;
        }

        $this->name = $name;
    }


    public function setConfig(Config $config)
    {
        $this->config = $config;
    }


    public function setDbModel($db_model)
    {
        $class = new ReflectionClass(get_class($this).'Db');

        if (!$class->isInstance($db_model) && !is_null($db_model))
        {
            return false;
        }

        $this->db_model = $db_model;
    }


    private function instantiateDbModel()
    {
        $class_name = get_class($this).'Db';
        $this->loadDbModelFile($class_name);

        $db = $this->config->getConfSection('db');
        $this->db_model = new $class_name(
                            $db['driver'], $db['type'], $db['host'], (int) $db['port'],
                            $db['db_name'], $db['user'], $db['pass'], $db['encoding'],
                            $db['options']['persistent']);
    }


    private function loadDbModelFile($file_name)
    {
        $model_path =  $this->config->getParamByPath('path/model')
                      .$file_name
                      .$this->config->getParamByPath('opt/all/file_suffix');

        if (!file_exists($model_path))
        {
            d::fp("model file does not exist ($model_path)", 'ERROR(code)::', 'e');
            return false;
        }

        include $model_path;
    }

}

?>