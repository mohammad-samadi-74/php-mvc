<?php

namespace App\Core\Facades;

/**
 * class Redirect
 * @package App\Core\Facades\Redirect
 * @method  route(string $routeName = '', array $args = [])
 * @method  string address($url, array $args = [])
 * @method  back()
 */

class Redirect extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'RedirectService';
    }
}