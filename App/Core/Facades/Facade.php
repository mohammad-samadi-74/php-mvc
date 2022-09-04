<?php

namespace App\Core\Facades;

class Facade
{

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return service(static::getFacadeAccessor())->$name(...$arguments);
    }


}