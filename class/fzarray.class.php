<?php

/**
 * Description of fzarray
 *
 * @author imerin
 */
class FzArray
{

    static public function searchMultiArrayByKey($name, $haystack)
    {
        $res = false;

        if (is_array($haystack) && !empty($haystack))
        {
            if (array_key_exists($name, $haystack))
            {
                $res = $haystack[$name];
            }
            else
            {
                while ((list($key, $value) = each($haystack)) && !$res)
                {
                    $res = self::searchMultiArrayByKey($name, $value);
                }
            }
        }

        return $res;
    }


    static public function searchMultiArrayByPath($array_path, $haystack)
    {
        $path_element = array_shift($array_path);

        if (!array_key_exists($path_element, $haystack))
        {
            return false;
        }

        if (count($array_path) === 0)
        {
            return $haystack[$path_element];
        }
        else
        {
            return self::searchMultiArrayByPath($array_path, $haystack[$path_element]);
        }
    }

}

?>