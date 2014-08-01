<?php

/**
 * Description of Debug (d)
 *
 * @author imerin
 */

class d
{
    static private $enabled;
    static private $error_level = NONE;
    static private $log_level = NONE;


    static public function getEnabled()
    {
        return self::$enabled;
    }


    static public function getErrorLevel()
    {
        return self::$error_level;
    }


    static public function getLogLevel()
    {
        return self::$log_level;
    }


    static public function setEnabled($state = false)
    {
        if (!is_bool($state))
        {
            self::$enabled = false;
            FB::setEnabled(false);
            return false;
        }

        self::$enabled = $state;
        FB::setEnabled($state);
    }


    static public function setErrorLevel($level)
    {
        if (!Sanitize::isBetweenInteger($level, NONE, MAX_ERROR_LEVEL))
        {
            self::$error_level = NONE;
        }

        self::$error_level = $level;
    }


    static public function setLogLevel($level)
    {
        if (!Sanitize::isBetweenInteger($level, NONE, MAX_LOG_LEVEL))
        {
            self::$log_level = NONE;
        }

        self::$log_level = $level;
    }


    static public function fp($var, $label = '', $action = 'log')
    {
        if (!self::$enabled)
        {
            return false;
        }

        self::translateAction($var, $label, $action);
    }


    static public function gs($label, $collapsed = true, $color = '#0000FF')
    {
        FB::group($label, array('Collapsed' => $collapsed, 'Color' => $color));
    }


    static public function ge()
    {
        FB::groupEnd();
    }


    static private function translateAction($var, $label, $action)
    {
        switch ($action)
        {
            case 'l':
            case 'log':
                fb($var, $label, FirePHP::LOG);
                break;
            case 'i':
            case 'info':
                fb($var, $label, FirePHP::INFO);
                break;
            case 'w':
            case 'warn':
                fb($var, $label, FirePHP::WARN);
                break;
            case 'e':
            case 'error':
                fb($var, $label, FirePHP::ERROR);
                break;
            case 'x':
            case 'exception':
                fb($var, $label, FirePHP::EXCEPTION);
                break;
            case 'd':
            case 'dump':
                fb($var, $label, FirePHP::DUMP);
                break;
            case 't':
            case 'table':
                fb($var, $label, FirePHP::TABLE);
                break;
            case 'tr':
            case 'trace':
                fb($var, $label, FirePHP::TRACE);
                break;
            case 'gs':
            case 'group_start':
                if ($label == '')
                {
                    $label = $var;
                }
                fb($var, $label, FirePHP::GROUP_START);                
                break;
            case 'ge':
            case 'group_end':
                fb($var, $label, FirePHP::GROUP_END);
                break;
            default :
                fb($var, $label, FirePHP::LOG);
                break;
        }
    }


    static public function pre($var = null, $message = '', $show_line_number = true)
    {
        echo '<pre>';
        
        if ($message)
        {
            echo "<b>$message</b><br/>";
        }

        if ($var)
        {
            var_dump($var);
        }

        if ($show_line_number)
        {
            $line_data = array_shift(debug_backtrace());

            echo '<b>'. basename($line_data['file']) .'</b> $nbsp; <font color="red">'.
                        $line_data['line'] .'</font> &nbsp; <font color="green">'.
                        $line_data['function'] .'()</font> &nbsp; --'.
                        dirname($line_data['file']) .'/<br/>';
        }

        echo '</pre><br/>';
    }


    static public function trace($full = false, $message = 'System trace:')
    {
        echo "<pre><b>$message</b><br/><br/>";

        $backtrace = debug_backtrace();
        unset($backtrace[0]);

        if ($full)
        {
            pre($backtrace);
        }
        else
        {
            array_walk(debug_backtrace(),
                        function($item) {
                            echo '<b>'. basename($item['file']) .'</b> $nbsp; <font color="red">'.
                                        $item['line'] .'</font> &nbsp; <font color="green">'.
                                        $item['function'] .'()</font> &nbsp; --'.
                                        dirname($item['file']) .'/<br/>';
                        });
        }

        echo '</pre><br/>';
    }
  
}

?>