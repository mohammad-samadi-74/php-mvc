<?php

namespace App\Core\Facades;

/**
 * class Gate
 * @package App\Core\Facades\Gate
 * @method  bool define($gateName ,callable  $callback,array $args=[])
 * @method  bool before($gateName ,callable  $callback,array $args=[])
 * @method  false|mixed|void allows($gateName, array $args=[])
 * @method  bool denies($gateName)
 * @method  false|mixed|void check($gateName)
 */

class Gate extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'GateService';
    }

}