<?php

define('CLASS_PATH', APP_PATH.'class'.DIRECTORY_SEPARATOR);


//Functions, and Autoload
function merge_files_array($files_arrays)
{
    $merged_array = array();

    foreach ($files_arrays as $files)
    {
        $merged_array = array_merge($merged_array, $files);
    }

    return $merged_array;
}
/*
function __autoload($class_name)
{
    if (!file_exists(CLASS_PATH.$class_name).'.class.php')
    {
        return false;
    }

    require_once CLASS_PATH.$class_name .'.class.php';
}*/


function __autoload($class_name)
{
    $filename = strtolower($class_name) . '.class.php';
    $file = CLASS_PATH.$filename;

    if (file_exists($file) === false)
    {
        return false;
    }
    
    include ($file);
}


//Load fw configuration
require_once CONF_PATH .'config.inc.php';

if (!file_exists(CONF_PATH .'config.inc.php'))
{
    echo "e: conf file does not exist";
    die();       //e: conf file does not exist
}


//Load main classes and libraries
$classes = merge_files_array($conf['file']['class']);
$libs = merge_files_array($conf['file']['lib']);

foreach ($classes as $file_name)
{
    if (!file_exists($conf['path']['class'].$file_name))
    {
        echo "e: class file does not exist ($conf[path][class].$file_name)";
        die();      //e: class file does not exist
    }
//echo ('Loading class:  '.$conf['path']['class'].$file_name.'<br/>');
    require_once $conf['path']['class'].$file_name;
}

foreach ($libs as $file_name)
{
    if (!file_exists($conf['path']['vendor']. $file_name))
    {
        echo "e: lib file does not exist (". $conf['path']['vendor'] ." $file_name)";
        die();      //e: lib file does not exist
    }
//echo ('Loading lib:  '.$conf['path']['vendor'].$file_name.'<br/>');
    require_once $conf['path']['vendor'].$file_name;
}


//$registry = new Registry($conf);


?>