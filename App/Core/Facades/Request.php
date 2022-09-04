<?php

namespace App\Core\Facades;

/**
 * class Request
 * @package App\Core\Facades\Request
 * @method  put($data)
 * @method  array all()
 * @method  array get(string $name)
 * @method  resetRequests()
 */

class Request extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'RequestService';
    }

}