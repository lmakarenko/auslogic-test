<?php

namespace Common;

/**
 * Class Response
 * Works with response data (sets headers, cookies)
 * @package Common
 */
class Response
{
    /**
     * Sets HTTP headers
     * @param array $params
     */
    public static function setHeaders(Array $params = [])
    {
        foreach($params as $name => $value) {
            header( "$name: $value");
        }
    }

    /**
     * Sets a cookie
     * @param array $cookie
     */
    public static function setCookie(Array $cookie)
    {
        $cookie = $cookie ? (object)$cookie : null;
        if($cookie) {
            setcookie($cookie->name, $cookie->value, $cookie->expire);
        }
    }
}