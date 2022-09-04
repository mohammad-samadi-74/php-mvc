<?php

namespace App\Core\Facades;

/**
 * class Cookie
 * @package App\Core\Facades\Cookie
 * @method  void  get($name)
 * @method  mixed set($name, $value)
 */

class Cookie extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'CookieService';
    }
}