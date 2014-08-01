<?php

/**
 * Description of sanitize
 *
 * @author imerin
 */

class Sanitize
{

    static public function isPostiveInteger($value)
    {
        return (is_int($value) && $value >= 0);
    }


    static public function isPositiveFloat($value)
    {
        return (is_float($value) && $value >= 0);
    }


    static public function isBetween($value, $floor, $ceil)
    {
        return ($value >= $floor && $value <= $ceil);
    }


    static public function isBetweenInteger($value, $floor, $ceil)
    {
        return (is_int($value) && self::isBetween($value, $floor, $ceil));
    }


    static public function isBetweenFloat($value, $floor, $ceil)
    {
        return (is_float($value) && self::isBetween($value, $floor, $ceil));
    }


    static public function isLetterString($value)
    {
        return (is_string($value) && preg_match('/^[a-zA-Z]*$/', $value));
    }


    static public function isAlphanumericString($value)
    {
        return (is_string($value) && preg_match('/^[a-zA-Z0-9]*$/', $value));
    }


    static public function isNumericString($value)
    {
        return (is_string($value) && preg_match('/^[0-9]*$/', $value));
    }


    static public function isFloatString($value)
    {
        return (is_string($value) && preg_match('/^[0-9]+\.[0-9]+$/', $value));
    }


    static public function isDateString($value)
    {
        return (is_string($value) &&
                preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $value));
    }


    static public function isTimeString($value)
    {
        return (is_string($value) &&
                preg_match('/^[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/', $value));
    }


    static public function isDateTimeString($value)
    {
        return (is_string($value) &&
                preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\ [0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/', $value));
    }


    static public function isInjectedString($value)
    {
        //@TODO: check for sql injections (UNION, OR, --, ;)
        return false;
    }


    static public function isHtmlString($value, array $allowed_tags)
    {
        //@TODO: check if the string has not allowed html tags
        return true;
    }

}

?>