<?php

namespace Common;

/**
 * Class Request
 * Works with request input data
 * @package Common
 */
class Request
{
    /**
     * Reads element from $_REQUEST global array
     * @param $key
     * @return mixed|null
     */
    public static function get($key)
    {
        if(isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }
        return null;
    }

    /**
     * Returns HTTP referer's domain from $_SERVER['HTTP_REFERER']
     * @return mixed
     */
    public static function getReferer()
    {
        return parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    }
}