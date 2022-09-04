<?php

namespace App\Core\Facades;

class Middleware extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'MiddlewareService';
    }
}