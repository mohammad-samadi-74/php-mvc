<?php

namespace App\Core\Facades;

/**
 * class DB
 * @package App\Core\Facades\DB
 * @method  static  get()
 * @method  static all()
 * @method  static find(int $id)
 * @method  static first()
 * @method  static take(int $count)
 * @method  static where($key, $value, string $operator = "=")
 * @method  static limit(int $number = 1)
 * @method  static orderBy($field, string $flag = "ASC")
 */

class DB extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'DBService';
    }
}