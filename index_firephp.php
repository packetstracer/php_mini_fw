<?php

/////////////
//FB USE ////
/////////////
$var = array('uno' => 1, 'dos' => 2, 'tres' => 3);

// INSTANTATION
//Dynamic Way
require_once LIB_PATH.'vendor/FirePHPCore/FirePHP.class.php';
$fp = FirePHP::getInstance(true);
$fp->setEnabled(true);
$fp->log($var, 'mi_mensaje dinamico');
//$fp->fb($var, 'mi mensaje dinamico con fb()');

//Static Way
require_once LIB_PATH.'vendor/FirePHPCore/fb.php';
FB::setEnabled(true);   //activate or deactivate FirePHP
FB::send($var, 'mi mensaje statico');
//fb($var, 'mi mensaje estatico con fb()');



// OPTIONS AND OBJECT FILTERS ???
$options = array('maxObjectDepth' => 5,
                 'maxArrayDepth' => 5,
                 'maxDepth' => 10,
                 'useNativeJsonEncode' => true,
                 'includeLineNumbers' => true);

$fp->getOptions();
$fp->setOptions($options);
//FB::setOptions($options);

$fp->setObjectFilter('ClassName', array('MemberName'));  //???


// EXCEPTIONS: i guess that execution is stopped with and error exception, so i comment it out
/*
$fp->registerErrorHandler($throwErrorExceptions=false);
$fp->registerExceptionHandler();
$fp->registerAssertionHandler($convertAssertionErrorsToExceptions=true,
                                $throwAssertionExceptions=false);

try
{
  throw new Exception('Test Exception');
}
catch(Exception $e)
{
  $fp->error($e);  // or FB::
  $fp->exception($e);

  //with fb object
  //$fp->fb($e, 'exceptionEtiq8', FirePHP::EXCEPTION);
  //$fp->fb($e, 'errorEtiq5', FirePHP::ERROR);
}
*/


// GROUPS   NO RULA, PORQUE???
$fp->group('Test Group');
$fp->log('Hello World');
$fp->groupEnd();
$fp->group('Collapsed and Colored Group', array('Collapsed' => true, 'Color' => '#FF00FF'));
$fp->groupEnd();



// LOG, INFO, WARN, ERROR: from less to more priority
$fp->log('Plain Message');     // or FB::
$fp->log('Message','Optional Label');
$fp->info('Info Message');     // or FB::
$fp->warn('Warn Message');     // or FB::
$fp->error('Error Message');   // or FB::


// TABLE
$table   = array();
$table[] = array('Col 1 Heading','Col 2 Heading');
$table[] = array('Row 1 Col 1','Row 1 Col 2');
$table[] = array('Row 2 Col 1','Row 2 Col 2');
$table[] = array('Row 3 Col 1','Row 3 Col 2');

$fp->table('Table Label', $table);  // or FB::
//$fp->fb($table, 'Table Label', FirePHP::TABLE);


// TRACE
function my_trace($fp)
{
    $fp->trace('Trace inside my_trace()');
}
my_trace($fp);
$fp->trace('Trace Label');  // or FB::
//$fp->fb('Trace Label', FirePHP::TRACE);



//PROCEDURAL API : The same functionality but using only the method fb()
//  'LOG', 'INFO', 'WARN', 'ERROR', 'DUMP', 'TRACE', 'EXCEPTION', 'TABLE', 'GROUP_START', 'GROUP_END'
// Dynamic use: $fp->fb() - Static use: fb()
fb($var);
fb($var, 'Etiq1');
fb($var, 'logEtiq2', FirePHP::LOG);
fb($var, 'infoEtiq3', FirePHP::INFO);
fb($var, FirePHP::WARN);                         //without optional label
fb($var, 'warnEtiq4', FirePHP::WARN);
fb($var, 'errorEtiq5', FirePHP::ERROR);
fb($var, 'dumpEtiq6', FirePHP::DUMP);
fb($var, 'traceEtiq7', FirePHP::TRACE);
fb($var, 'exceptionEtiq8', FirePHP::EXCEPTION);  //see also at exceptions section
fb($table, 'tableEtiq9', FirePHP::TABLE);
fb($var, 'group_startEtiq10', FirePHP::GROUP_START);
    fb($var, 'logEtiq2', FirePHP::LOG);
    fb($var, 'infoEtiq3', FirePHP::INFO);
    fb($var, 'group_startEtiq10', FirePHP::GROUP_START);
        fb($var, 'logEtiq2', FirePHP::LOG);
        fb($var, 'infoEtiq3', FirePHP::INFO);
    fb($var, 'group_endEtiq11', FirePHP::GROUP_END);
fb($var, 'group_endEtiq11', FirePHP::GROUP_END);

?>