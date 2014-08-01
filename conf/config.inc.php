<?php

/**
 * CONSTANTS
 */

//LOGS AND ERRORS
define('NONE',              0);
define('NORMAL',            1);
define('VERBOSE',           2);

define('MAX_ERROR_LEVEL',   2);
define('MAX_LOG_LEVEL',     2);




/**
 * ENVIRONMENT
 */

$conf['env']['stage'] = 'dev';   // dev | test | stage | prod
$conf['env']['root'] = '';




/**
 * DATABASE
 */

$conf['db']['type']     = 'mysql';          // mysql | pgsql | mssql | oracle
$conf['db']['driver']   = 'pdo';
$conf['db']['host']     = 'localhost';
$conf['db']['port']     = '3306';
$conf['db']['user']     = 'developer';
$conf['db']['pass']     = 'amarok00';
$conf['db']['db_name']  = 'fz_intranew_dev';
$conf['db']['encoding'] = 'utf-8';

$conf['db']['options']['persistent'] = true;




/**
 * PATHS SECTION
 */
$conf['path']['app']        = getcwd().DIRECTORY_SEPARATOR;
$conf['path']['class']      = $conf['path']['app'] .'class/';
$conf['path']['lib']        = $conf['path']['app'] .'lib/';
$conf['path']['vendor']     = $conf['path']['lib'] .'vendor/';
$conf['path']['js']         = $conf['path']['vendor'] .'js/';
$conf['path']['controller'] = $conf['path']['app'] .'controller/';
$conf['path']['model']      = $conf['path']['app'] .'model/';
$conf['path']['view']       = $conf['path']['app'] .'view/';
$conf['path']['layout']     = $conf['path']['app'] .'view/layout/';
$conf['path']['template']   = $conf['path']['app'] .'view/';
$conf['path']['test']       = $conf['path']['app'] .'test/';
$conf['path']['log']        = $conf['path']['app'] .'log/';
$conf['path']['public']     = $conf['path']['app'] .'public/';




/**
 * FILES SECTION
 */

//CLASSES : ...['ClassName'] = 'class_name.class.php'
$conf['file']['class']['main']['d']             = 'debug.class.php';
$conf['file']['class']['main']['Application']   = 'application.class.php';
$conf['file']['class']['main']['Registry']      = 'registry.class.php';
$conf['file']['class']['app']['Config']         = 'config.class.php';
$conf['file']['class']['app']['Request']        = 'request.class.php';
$conf['file']['class']['app']['Sanitize']       = 'sanitize.class.php';
$conf['file']['class']['app']['Controller']     = 'controller.class.php';
$conf['file']['class']['app']['Model']          = 'model.class.php';
$conf['file']['class']['app']['View']           = 'view.class.php';
$conf['file']['class']['app']['Template']       = 'template.class.php';
$conf['file']['class']['app']['Layout']         = 'layout.class.php';
$conf['file']['class']['app']['FzException']    = 'fzexception.class.php';
$conf['file']['class']['app']['FzArray']        = 'fzarray.class.php';

//classes to be instantiated (neither abstract nor static ones)
$conf['class']['instantiable'] =
        array(
            'Application',
            'Template', 'Layout'
        );


//LIBS AND VENDOR LIBS : ...['ClassName']       = 'relative_path/lib_file_name'
//$conf['file']['lib']['vendor']['FirePhp']     = 'FirePHPCore/FirePHP.class.php';  //firephp dynamic
$conf['file']['lib']['vendor']['fb']            = 'FirePHPCore/fb.php';                    //firephp static
//$conf['file']['lib']['vendor']['PHPUnit']     = 'PHPUnit/Framework.php';    //??
//$conf['file']['lib']['vendor']['APC']         = '';  //hay que instalarlar en el apache
//$conf['file']['jslib']['vendor']['jQuery']    = '';
//$conf['file']['jslib']['vendor']['Motools']   = '';


//LOGS
$conf['file']['log']['error']   = 'error.log';
$conf['file']['log']['access']  = 'access.log';




/**
 * OPTIONS
 */

$conf['opt']['debug']['enabled']        = true;             //if statement to set it to false when in production
$conf['opt']['debug']['error_level']    = VERBOSE;          // 0 = none | 1 = normal | 2 = verbose
$conf['opt']['debug']['log_level']      = VERBOSE;          // 0 = none | 1 = normal | 2 = verbose

$conf['opt']['testing']['enabled']      = false;
$conf['opt']['cache']['enabled']        = false;
$conf['opt']['js']['enabled']           = true;


$conf['opt']['all']['file_suffix']              = '.php';
$conf['opt']['controller']['file_suffix']       = 'Controller.php';       //controller_name + file_suffix = controller_filename
$conf['opt']['controller']['action_suffix']     = 'Action';
$conf['opt']['model']['file_suffix']            = 'Model.php';
$conf['opt']['view']['file_suffix']             = '.phtml';




/**
 * MVC
 */

//CONTROLLERS
$conf['mvc']['controller']['default'] = 'main';
$conf['mvc']['controller']['another'] = 'another';


//VIEWS
$conf['mvc']['view']['default'] = 'index';

$conf['mvc']['layout']['default']['name'] = 'main';
$conf['mvc']['layout']['default']['title'] = 'Layout Por Defecto';

$conf['mvc']['layout']['controller']['action']['name'] = 'adifferentLayoutForAControllerAction';
$conf['mvc']['layout']['controller']['action']['title'] = 'el titulo de la pagina';
$conf['mvc']['layout']['controller']['action']['param1'] = 'valor_param1';
$conf['mvc']['layout']['controller']['action']['param2'] = 'valor_param2';
$conf['mvc']['layout']['controller']['action']['param3'] = 'valor_param3';

$conf['mvc']['layout']['another_controller']['all']['name'] = 'anotherLayout';   //this one is valid for all controller's actions

$conf['mvc']['layout']['main']['index']['name'] = 'main';
$conf['mvc']['layout']['main']['index']['title'] = 'el titulo del layout del main';
$conf['mvc']['layout']['main']['index']['param1'] = 'valor param1 main';


//MODELS
$conf['mvc']['model']['default'] = 'main';


//ENTITY TYPES
$conf['mvc']['entities'] = array_keys($conf['mvc']);



?>