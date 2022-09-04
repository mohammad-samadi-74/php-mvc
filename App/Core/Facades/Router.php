<?php

namespace App\Core\Facades;

/**
 * class Redirect
 * @package App\Core\Facades\Redirect
 * @method  route(string $routeName = '', array $args = [])
 * @method  string address($url, array $args = [])
 * @method  back()
 */

class Router extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'RouterService';
    }
}