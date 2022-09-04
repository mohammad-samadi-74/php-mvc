<?php

namespace App\Core\Facades;

/**
 * class Auth
 * @package App\Core\Facades\Auth
 * @method  bool check()
 * @method  mixed auth()
 * @method  bool login(int|object $user, bool $remember = false)
 * @method  bool logout()
 */


class Auth extends Facade
{

    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'AuthService';
    }
}