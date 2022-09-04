<?php

namespace App\Core\Services;

class CookieService
{
    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value){
        setcookie($name,json_encode($value));
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name): mixed
    {
        return isset($_COOKIE[$name]) ? json_decode($_COOKIE[$name]) : null;
    }
}