<?php

namespace App\Core\Services;


class GateService
{
    protected array $gates = [];

    public function define($gateName ,callable  $callback,array $args=[]): bool
    {
        if (!isset($this->gates[$gateName]) && !isset($this->gates['before'][$gateName])){
            $this->gates[$gateName] = ['args'=>$args , 'callback'=>$callback];
            return true;
        }

        return trigger_error("Gate With Name : $gateName Already Exists !");
    }

    public function before($gateName ,callable  $callback,array $args=[]): bool
    {
        if (!isset($this->gates[$gateName]) && !isset($this->gates['before'][$gateName])){
            $this->gates['before'][$gateName] = ['args'=>$args , 'callback'=>$callback];
            return true;
        }else{
            return trigger_error("Gate With Name : $gateName Already Exists !");
        }

    }

    /**
     * @param $gateName
     * @param array $args
     * @return false|mixed|void
     */
    public function allows($gateName, array $args=[]){
        return $this->check($gateName);

    }

    /**
     * @param $gateName
     * @return bool
     */
    public function denies($gateName): bool
    {
        return ! ($this->check($gateName));
    }

    /**
     * @param $gateName
     * @return false|mixed|void
     */
    public function check($gateName){
        if (isset($this->gates['before'][$gateName])){
            return call_user_func($this->gates['before'][$gateName]['callback']);
        }

        if (isset($this->gates[$gateName])){
            return call_user_func($this->gates[$gateName]['callback']);
        }

        trigger_error("Doesnt Exists Any Gate With This Name : $gateName !");
    }
}