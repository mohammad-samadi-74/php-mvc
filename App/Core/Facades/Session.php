<?php

namespace App\Core\Facades;

/**
 * class Session
 * @package App\Core\Facades\Session
 * @method  static set(string $name, string|array $value)
 * @method  mixed get(string $name)
 * @method  mixed getFlash(string $name)
 * @method  bool has(string $name, $value = null)
 * @method  bool hasFlash(string $name, $value = null)
 * @method  array all()
 * @method  static delete($name)
 * @method  static flush()
 */

class Session extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'SessionService';
    }
}