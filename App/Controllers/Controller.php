<?php

namespace App\Controllers;

use App\Core\Services\ValidationService;
use Exception;
use Plasticbrain\FlashMessages\FlashMessages;

class Controller
{

    protected FlashMessages $flash;

    public function __construct()
    {
        $this->flash = new FlashMessages();
    }

    /**
     * @throws Exception
     */
    public function validation($data, $rules){



        $validator = service('ValidationService');


        $status = $validator->make($data,$rules);

        if ($validator->hasErrors()){

            $flash = $this->flash;

            $this->saveOldValuesInSession($validator);

            //throw flash errors
            foreach($validator->getErrors() as $errors){
                array_map(function($error) use ($flash){
                    $flash->error($error);
                },$errors);
            }

            return false;
        }


        if (isset($validator->oldValues['confirm']))
            unset($validator->oldValues['confirm']);

        return $validator->oldValues;

    }

    /**
     * @param ValidationService $validator
     */
    protected function saveOldValuesInSession(ValidationService $validator): void
    {
        array_map(function ($value, $key) {
            $_SESSION[$key] = $value;
        }, $validator->oldValues, array_keys($validator->oldValues));
    }

}