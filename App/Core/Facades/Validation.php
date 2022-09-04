<?php

namespace App\Core\Facades;

/**
 * class Validation
 * @package App\Core\Facades\Validation
 * @method  static|bool make(array $data, array $rules, array|null $errors = null)
 * @method  bool hasErrors()
 * @method  array getErrors()
 */

class Validation extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'ValidationService';
    }
}