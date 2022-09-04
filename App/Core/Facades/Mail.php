<?php

namespace App\Core\Facades;

/**
 * class Gate
 * @package App\Core\Facades\Gate
 * @method  sendMail()
 * @method  static subject(string $value='')
 * @method  static to($value, $name=null)
 * @method  static from($value, $name=null)
 * @method  static cc($value)
 * @method  static bcc($value)
 * @method  static replyTo($value,$name=null)
 * @method  static body($value='')
 */

class Mail extends Facade
{
    public static function getFacadeAccessor(){
        return 'MailService';
    }
}