<?php

namespace App\Core\library;

use App\Core\Facades\DB;

trait Rules
{
    public array $errors = [];
    public array $oldValues = [];

    protected function required($data)
    {

        if (!isset($data['value']) || empty(trim($data['value']))) {
            $this->errors[$data['key']][] = "{$data['key']} is required";
            return false;
        }

    }

    protected function email($data)
    {
        if (!filter_var($data['value'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$data['key']][] = "please enter an validate email";
            return false;
        }
    }

    protected function min($data)
    {
        if (strlen($data['value']) < (int) $data['param']) {
            $this->errors[$data['key']][] = "{$data['key']} must have at least {$data['param']} characters";
            return false;
        }
    }

    protected function max($data)
    {
        if (strlen($data['value']) > (int) $data['param']) {
            $this->errors[$data['key']][] = "{$data['key']} cant have more than {$data['param']} characters";
            return false;
        }
    }

    protected function confirm($data){

        $param = $data['param'] ?? 'password';


        if (!isset($this->oldValues['confirm']) || empty(trim($this->oldValues['confirm']))){
            $this->errors[$data['key']][]= "confirm-{$data['key']} cant be empty";
            return false;
        }

        $confirmValue = $this->oldValues['confirm'];

        if($data['value'] !== $confirmValue){
            $this->errors[$data['key']][]= "{$data['key']} and confirm-{$data['key']} doesnt have same value";
            return false;
        }
    }

    protected function unique($data){
        list($key,$value,$param) = [$data['key'],$data['value'],$data['param']];
        if (strpos($param,',')){
            list($table,$field) = explode(',',$param);
        }else{
            $table = $param;
        }

        $status = DB::table($table)->where($key,$value)->first();

        if ($status){
            $this->errors[$data['key']][]= "this email ($value) has already token by another user ! please enter a new email";
            return false;
        }

    }
}